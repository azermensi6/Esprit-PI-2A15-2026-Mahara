<?php

namespace App\Controllers;

use App\Models\Formation;
use DateTime;

/**
 * Module P5 : formations.
 *  - back office  : liste, ajout, modification, suppression ;
 *  - front office : catalogue (recherche multicritère) et page détail.
 * Jointure : formation.id_categorie_formation -> categorie_formation.
 */
class FormationController extends Controller
{
    /** Valeurs autorisées par la base (ENUM) => libellé affiché */
    public const NIVEAUX = ['debutant' => 'Débutant', 'intermediaire' => 'Intermédiaire', 'avance' => 'Avancé'];
    public const MODES   = ['en_ligne' => 'En ligne', 'presentiel' => 'Présentiel', 'hybride' => 'Hybride'];

    /** Tri du catalogue : liste fermée (on ne met jamais une valeur de l'utilisateur dans ORDER BY) */
    private const TRIS = [
        'date'  => 'f.date_debut IS NULL, f.date_debut ASC',
        'prix'  => 'f.prix ASC',
        'duree' => 'f.duree_heures ASC',
    ];

    /** Partie commune : formation + nom de sa catégorie (JOIN) */
    private const SELECT = 'SELECT f.*, c.nom AS categorie
            FROM formation f
            JOIN categorie_formation c ON f.id_categorie_formation = c.id_categorie_formation';

    /** Réutilise l'accès aux catégories (liste déroulante, vérification d'existence) */
    private CategorieFormationController $categories;

    public function __construct()
    {
        parent::__construct();
        $this->categories = new CategorieFormationController();
    }

    // ==============================================================
    // ACCÈS AUX DONNÉES (requêtes préparées)
    // ==============================================================

    /** @return Formation[] toutes les formations avec leur catégorie */
    public function allWithCategorie(): array
    {
        $rows = $this->db->query(self::SELECT . ' ORDER BY f.date_creation DESC')->fetchAll();
        return array_map(fn(array $row) => Formation::fromArray($row), $rows);
    }

    /**
     * Recherche multicritère (front office). Filtres facultatifs :
     * q (mot-clé), categorie (id), niveaux (tableau), mode, prix_max.
     * @return Formation[]
     */
    public function search(array $filtres, string $tri): array
    {
        $sql    = self::SELECT . ' WHERE 1 = 1';
        $params = [];

        if ($filtres['q'] !== '') {
            $sql .= ' AND (f.titre LIKE :q1 OR f.description LIKE :q2)';
            $params['q1'] = $params['q2'] = '%' . $filtres['q'] . '%';
        }
        if ($filtres['categorie'] > 0) {
            $sql .= ' AND f.id_categorie_formation = :cat';
            $params['cat'] = $filtres['categorie'];
        }
        if ($filtres['niveaux'] !== []) {
            $marques = [];
            foreach ($filtres['niveaux'] as $i => $niveau) {
                $marques[] = ':niv' . $i;
                $params['niv' . $i] = $niveau;
            }
            $sql .= ' AND f.niveau IN (' . implode(', ', $marques) . ')';
        }
        if ($filtres['mode'] !== '') {
            $sql .= ' AND f.mode = :mode';
            $params['mode'] = $filtres['mode'];
        }
        if ($filtres['prix_max'] !== '') {
            $sql .= ' AND f.prix <= :prix_max';
            $params['prix_max'] = $filtres['prix_max'];
        }
        $sql .= ' ORDER BY ' . (self::TRIS[$tri] ?? self::TRIS['date']);

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return array_map(fn(array $row) => Formation::fromArray($row), $stmt->fetchAll());
    }

    public function findById(int $id): ?Formation
    {
        $stmt = $this->db->prepare(self::SELECT . ' WHERE f.id_formation = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? Formation::fromArray($row) : null;
    }

    public function insert(Formation $f): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO formation (titre, description, niveau, duree_heures, mode, prix, date_debut, id_categorie_formation)
             VALUES (:titre, :description, :niveau, :duree, :mode, :prix, :date_debut, :cat)'
        );
        return $stmt->execute($this->params($f));
    }

    public function update(Formation $f): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE formation
             SET titre = :titre, description = :description, niveau = :niveau, duree_heures = :duree,
                 mode = :mode, prix = :prix, date_debut = :date_debut, id_categorie_formation = :cat
             WHERE id_formation = :id'
        );
        return $stmt->execute($this->params($f) + ['id' => $f->getId()]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM formation WHERE id_formation = :id');
        return $stmt->execute(['id' => $id]);
    }

    /** Règle métier : ce titre existe-t-il déjà dans cette catégorie ? */
    public function titreExiste(string $titre, int $idCategorie, int $exceptId = 0): bool
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM formation
             WHERE titre = :titre AND id_categorie_formation = :cat AND id_formation <> :id'
        );
        $stmt->execute(['titre' => $titre, 'cat' => $idCategorie, 'id' => $exceptId]);
        return (int) $stmt->fetchColumn() > 0;
    }

    /** Paramètres communs à insert() et update() */
    private function params(Formation $f): array
    {
        return [
            'titre'       => $f->getTitre(),
            'description' => $f->getDescription(),
            'niveau'      => $f->getNiveau(),
            'duree'       => $f->getDureeHeures(),
            'mode'        => $f->getMode(),
            'prix'        => $f->getPrix(),
            'date_debut'  => $f->getDateDebut(),
            'cat'         => $f->getIdCategorieFormation(),
        ];
    }

    // ==============================================================
    // BACK OFFICE : index.php?page=admin-formations
    // ==============================================================

    public function liste(): void
    {
        $this->requireAdmin();
        $this->page  = 'admin-formations';
        $this->title = 'Formations | Mahara Admin';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->delete((int) input($_POST, 'delete_id'));
            setFlash('success', 'Formation supprimée.');
            $this->redirect('admin-formations');
        }

        $this->render('formations', [
            'formations' => $this->allWithCategorie(),
            'categories' => $this->categories->all(),
            'niveaux'    => self::NIVEAUX,
            'modes'      => self::MODES,
            'flash'      => takeFlash(),
        ]);
    }

    // ==============================================================
    // BACK OFFICE : index.php?page=admin-formation-form (&id=5 pour modifier)
    // ==============================================================

    public function formulaire(): void
    {
        $this->requireAdmin();
        $this->page  = 'admin-formation-form';
        $this->title = 'Ajouter une formation | Mahara Admin';

        $id  = (int) input($_GET, 'id');
        $old = [
            'titre' => '', 'description' => '', 'niveau' => 'debutant', 'duree_heures' => '',
            'mode' => 'en_ligne', 'prix' => '0', 'date_debut' => '', 'id_categorie_formation' => '',
        ];

        if ($id > 0) {
            $f = $this->findById($id);
            if ($f === null) {
                $this->redirect('admin-formations');
            }
            $old = [
                'titre' => $f->getTitre(), 'description' => (string) $f->getDescription(), 'niveau' => $f->getNiveau(),
                'duree_heures' => (string) $f->getDureeHeures(), 'mode' => $f->getMode(), 'prix' => (string) $f->getPrix(),
                'date_debut' => (string) $f->getDateDebut(), 'id_categorie_formation' => (string) $f->getIdCategorieFormation(),
            ];
            $this->title = 'Modifier une formation | Mahara Admin';
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($old as $champ => $_) {
                $old[$champ] = input($_POST, $champ);
            }
            $errors = $this->valider($old, $id);

            if ($errors === []) {
                $f = new Formation();
                $f->setId($id);
                $f->setTitre($old['titre']);
                $f->setDescription($old['description'] !== '' ? $old['description'] : null);
                $f->setNiveau($old['niveau']);
                $f->setDureeHeures((int) $old['duree_heures']);
                $f->setMode($old['mode']);
                $f->setPrix((float) $old['prix']);
                $f->setDateDebut($old['date_debut'] !== '' ? $old['date_debut'] : null);
                $f->setIdCategorieFormation((int) $old['id_categorie_formation']);

                if ($id > 0) {
                    $this->update($f);
                    setFlash('success', 'Formation modifiée.');
                } else {
                    $this->insert($f);
                    setFlash('success', 'Formation ajoutée.');
                }
                $this->redirect('admin-formations');
            }
        }

        $this->render('formation-form', [
            'id'         => $id,
            'old'        => $old,
            'errors'     => $errors,
            'categories' => $this->categories->all(),
            'niveaux'    => self::NIVEAUX,
            'modes'      => self::MODES,
        ]);
    }

    /** Validation PHP côté serveur : renvoie [champ => message] */
    private function valider(array $d, int $id): array
    {
        $errors = [];

        if ($d['titre'] === '') {
            $errors['titre'] = 'Le titre est obligatoire.';
        } elseif (mb_strlen($d['titre']) < 3 || mb_strlen($d['titre']) > 150) {
            $errors['titre'] = 'Le titre doit contenir entre 3 et 150 caractères.';
        }

        $idCat = (int) $d['id_categorie_formation'];
        if ($idCat <= 0 || $this->categories->findById($idCat) === null) {
            $errors['id_categorie_formation'] = 'Choisissez une catégorie valide.';
        } elseif (!isset($errors['titre']) && $this->titreExiste($d['titre'], $idCat, $id)) {
            $errors['titre'] = 'Une formation avec ce titre existe déjà dans cette catégorie.';
        }

        if (!isset(self::NIVEAUX[$d['niveau']])) {
            $errors['niveau'] = 'Niveau invalide.';
        }
        if (!isset(self::MODES[$d['mode']])) {
            $errors['mode'] = 'Mode invalide.';
        }

        $duree = filter_var($d['duree_heures'], FILTER_VALIDATE_INT);
        if ($duree === false || $duree < 1 || $duree > 500) {
            $errors['duree_heures'] = 'La durée doit être un nombre entier entre 1 et 500 heures.';
        }

        if (!is_numeric($d['prix']) || (float) $d['prix'] < 0) {
            $errors['prix'] = 'Le prix doit être un nombre positif ou nul.';
        }

        // Date facultative ; règle métier : pas dans le passé pour une NOUVELLE formation
        if ($d['date_debut'] !== '') {
            $date = DateTime::createFromFormat('Y-m-d', $d['date_debut']);
            if ($date === false || $date->format('Y-m-d') !== $d['date_debut']) {
                $errors['date_debut'] = 'Date invalide.';
            } elseif ($id === 0 && $date < new DateTime('today')) {
                $errors['date_debut'] = 'La date de début ne peut pas être dans le passé.';
            }
        }

        if (mb_strlen($d['description']) > 2000) {
            $errors['description'] = 'La description ne doit pas dépasser 2000 caractères.';
        }

        return $errors;
    }

    // ==============================================================
    // FRONT OFFICE : index.php?page=formations
    // ==============================================================

    public function catalogue(): void
    {
        $this->requireLogin('formations');

        $prixMax = input($_GET, 'prix_max');
        if ($prixMax !== '' && (!is_numeric($prixMax) || (float) $prixMax < 0)) {
            $prixMax = '';                                       // valeur invalide : filtre ignoré
        }
        $mode = input($_GET, 'mode');
        $tri  = input($_GET, 'tri');
        $niveaux = array_filter((array) ($_GET['niveau'] ?? []), 'is_string');

        $filtres = [
            'q'         => input($_GET, 'q'),
            'categorie' => (int) input($_GET, 'categorie'),
            'niveaux'   => array_values(array_intersect($niveaux, array_keys(self::NIVEAUX))),
            'mode'      => isset(self::MODES[$mode]) ? $mode : '',
            'prix_max'  => $prixMax,
        ];
        $tri = isset(self::TRIS[$tri]) ? $tri : 'date';

        $this->renderFront('formations', [
            'formations' => $this->search($filtres, $tri),
            'categories' => $this->categories->all(),
            'filtres'    => $filtres,
            'tri'        => $tri,
            'niveaux'    => self::NIVEAUX,
            'modes'      => self::MODES,
        ]);
    }

    // ==============================================================
    // FRONT OFFICE : index.php?page=formation-detail&id=3
    // ==============================================================

    public function detail(): void
    {
        $this->requireLogin('formation-detail');

        $formation = $this->findById((int) input($_GET, 'id'));
        if ($formation === null) {
            $this->redirect('formations');
        }

        $this->renderFront('formation-detail', [
            'formation' => $formation,
            'niveaux'   => self::NIVEAUX,
            'modes'     => self::MODES,
        ]);
    }
}
