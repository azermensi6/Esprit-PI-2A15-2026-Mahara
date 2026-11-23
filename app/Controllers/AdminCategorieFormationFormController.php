<?php

namespace App\Controllers;

use App\Models\CategorieFormation;

class AdminCategorieFormationFormController extends Controller
{
    protected string $page = 'admin-categorie-formation-form';
    protected string $title = 'Ajouter une catégorie de formation | Mahara Admin';

    public function index(): void
    {
        // ?id=3 dans l'URL => modification ; sinon => ajout
        $id  = (int) ($_GET['id'] ?? 0);
        $old = ['nom' => '', 'description' => ''];

        if ($id > 0) {
            $categorie = CategorieFormation::find($id);
            if ($categorie === false) {                 // id inconnu : retour à la liste
                header('Location: index.php?page=admin-categories-formation');
                exit;
            }
            $old = ['nom' => $categorie['nom'], 'description' => (string) $categorie['description']];
            $this->title = 'Modifier une catégorie de formation | Mahara Admin';
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old = [
                'nom'         => trim($_POST['nom'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
            ];
            $errors = $this->valider($old, $id);

            if ($errors === []) {
                $description = $old['description'] !== '' ? $old['description'] : null;
                if ($id > 0) {
                    CategorieFormation::update($id, $old['nom'], $description);
                    $message = 'Catégorie modifiée.';
                } else {
                    CategorieFormation::create($old['nom'], $description);
                    $message = 'Catégorie ajoutée.';
                }
                $_SESSION['flash'] = ['type' => 'success', 'message' => $message];
                header('Location: index.php?page=admin-categories-formation');
                exit;
            }
        }

        $this->render('categorie-formation-form', [
            'id'     => $id,
            'old'    => $old,
            'errors' => $errors,
        ]);
    }

    /** Validation PHP côté serveur : renvoie un tableau [champ => message d'erreur] */
    private function valider(array $d, int $id): array
    {
        $errors = [];

        if ($d['nom'] === '') {
            $errors['nom'] = 'Le nom est obligatoire.';
        } elseif (mb_strlen($d['nom']) < 3 || mb_strlen($d['nom']) > 80) {
            $errors['nom'] = 'Le nom doit contenir entre 3 et 80 caractères.';
        } elseif (CategorieFormation::nomExiste($d['nom'], $id)) {
            $errors['nom'] = 'Cette catégorie existe déjà.';
        }

        if (mb_strlen($d['description']) > 255) {
            $errors['description'] = 'La description ne doit pas dépasser 255 caractères.';
        }

        return $errors;
    }
}
