<?php

namespace App\Controllers;

use App\Models\CategorieFormation;

/**
 * Module P5 : catégories de formation (back office).
 * Jointure : formation.id_categorie_formation -> categorie_formation.
 */
class CategorieFormationController extends Controller
{
    // ==============================================================
    // ACCÈS AUX DONNÉES (requêtes préparées)
    // ==============================================================

    /** @return CategorieFormation[] triées par nom */
    public function all(): array
    {
        $rows = $this->db->query('SELECT * FROM categorie_formation ORDER BY nom')->fetchAll();
        return array_map(fn(array $row) => CategorieFormation::fromArray($row), $rows);
    }

    /** @return CategorieFormation[] avec le nombre de formations de chacune (LEFT JOIN) */
    public function allWithCount(): array
    {
        $rows = $this->db->query(
            'SELECT c.*, COUNT(f.id_formation) AS nb_formations
             FROM categorie_formation c
             LEFT JOIN formation f ON f.id_categorie_formation = c.id_categorie_formation
             GROUP BY c.id_categorie_formation
             ORDER BY c.nom'
        )->fetchAll();
        return array_map(fn(array $row) => CategorieFormation::fromArray($row), $rows);
    }

    public function findById(int $id): ?CategorieFormation
    {
        $stmt = $this->db->prepare('SELECT * FROM categorie_formation WHERE id_categorie_formation = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? CategorieFormation::fromArray($row) : null;
    }

    public function insert(CategorieFormation $c): bool
    {
        $stmt = $this->db->prepare('INSERT INTO categorie_formation (nom, description) VALUES (:nom, :description)');
        return $stmt->execute(['nom' => $c->getNom(), 'description' => $c->getDescription()]);
    }

    public function update(CategorieFormation $c): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE categorie_formation SET nom = :nom, description = :description WHERE id_categorie_formation = :id'
        );
        return $stmt->execute(['nom' => $c->getNom(), 'description' => $c->getDescription(), 'id' => $c->getId()]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM categorie_formation WHERE id_categorie_formation = :id');
        return $stmt->execute(['id' => $id]);
    }

    /** Règle métier : le nom est-il déjà pris ? (on ignore la catégorie $exceptId en modification) */
    public function nomExiste(string $nom, int $exceptId = 0): bool
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM categorie_formation WHERE nom = :nom AND id_categorie_formation <> :id'
        );
        $stmt->execute(['nom' => $nom, 'id' => $exceptId]);
        return (int) $stmt->fetchColumn() > 0;
    }

    /** Règle métier : combien de formations dépendent de cette catégorie ? */
    public function countFormations(int $id): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM formation WHERE id_categorie_formation = :id');
        $stmt->execute(['id' => $id]);
        return (int) $stmt->fetchColumn();
    }

    // ==============================================================
    // BACK OFFICE : index.php?page=admin-categories-formation
    // ==============================================================

    public function liste(): void
    {
        $this->requireAdmin();   // avant tout traitement
        $this->page  = 'admin-categories-formation';
        $this->title = 'Catégories de formation | Mahara Admin';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int) input($_POST, 'delete_id');
            // Règle métier : on ne supprime pas une catégorie qui contient des formations
            if ($this->countFormations($id) > 0) {
                setFlash('danger', 'Suppression impossible : cette catégorie contient encore des formations.');
            } else {
                $this->delete($id);
                setFlash('success', 'Catégorie supprimée.');
            }
            $this->redirect('admin-categories-formation');
        }

        $this->render('categories-formation', [
            'categories' => $this->allWithCount(),
            'flash'      => takeFlash(),
        ]);
    }

    // ==============================================================
    // BACK OFFICE : index.php?page=admin-categorie-formation-form (&id=3 pour modifier)
    // ==============================================================

    public function formulaire(): void
    {
        $this->requireAdmin();
        $this->page  = 'admin-categorie-formation-form';
        $this->title = 'Ajouter une catégorie de formation | Mahara Admin';

        $id  = (int) input($_GET, 'id');
        $old = ['nom' => '', 'description' => ''];

        if ($id > 0) {
            $categorie = $this->findById($id);
            if ($categorie === null) {
                $this->redirect('admin-categories-formation');
            }
            $old = ['nom' => $categorie->getNom(), 'description' => (string) $categorie->getDescription()];
            $this->title = 'Modifier une catégorie de formation | Mahara Admin';
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old = ['nom' => input($_POST, 'nom'), 'description' => input($_POST, 'description')];

            if ($old['nom'] === '') {
                $errors['nom'] = 'Le nom est obligatoire.';
            } elseif (mb_strlen($old['nom']) < 3 || mb_strlen($old['nom']) > 80) {
                $errors['nom'] = 'Le nom doit contenir entre 3 et 80 caractères.';
            } elseif ($this->nomExiste($old['nom'], $id)) {
                $errors['nom'] = 'Cette catégorie existe déjà.';
            }
            if (mb_strlen($old['description']) > 255) {
                $errors['description'] = 'La description ne doit pas dépasser 255 caractères.';
            }

            if ($errors === []) {
                $categorie = new CategorieFormation();
                $categorie->setId($id);
                $categorie->setNom($old['nom']);
                $categorie->setDescription($old['description'] !== '' ? $old['description'] : null);

                if ($id > 0) {
                    $this->update($categorie);
                    setFlash('success', 'Catégorie modifiée.');
                } else {
                    $this->insert($categorie);
                    setFlash('success', 'Catégorie ajoutée.');
                }
                $this->redirect('admin-categories-formation');
            }
        }

        $this->render('categorie-formation-form', ['id' => $id, 'old' => $old, 'errors' => $errors]);
    }
}
