<?php

namespace App\Controllers;

use App\Models\CategorieFormation;
use App\Models\Formation;

class AdminFormationFormController extends Controller
{
    protected string $page = 'admin-formation-form';
    protected string $title = 'Ajouter une formation | Mahara Admin';

    private const NIVEAUX = ['debutant', 'intermediaire', 'avance'];
    private const MODES   = ['en_ligne', 'presentiel', 'hybride'];

    public function index(): void
    {
        // ?id=5 dans l'URL => modification ; sinon => ajout
        $id  = (int) ($_GET['id'] ?? 0);
        $old = [
            'titre' => '', 'description' => '', 'niveau' => 'debutant',
            'duree_heures' => '', 'mode' => 'en_ligne', 'prix' => '0',
            'date_debut' => '', 'id_categorie_formation' => '',
        ];

        if ($id > 0) {
            $formation = Formation::find($id);
            if ($formation === false) {                  // id inconnu : retour à la liste
                header('Location: index.php?page=admin-formations');
                exit;
            }
            foreach ($old as $champ => $_) {
                $old[$champ] = (string) ($formation[$champ] ?? '');
            }
            $this->title = 'Modifier une formation | Mahara Admin';
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($old as $champ => $_) {
                $old[$champ] = trim($_POST[$champ] ?? '');
            }
            $errors = $this->valider($old, $id);

            if ($errors === []) {
                if ($id > 0) {
                    Formation::update($id, $old);
                    $message = 'Formation modifiée.';
                } else {
                    Formation::create($old);
                    $message = 'Formation ajoutée.';
                }
                $_SESSION['flash'] = ['type' => 'success', 'message' => $message];
                header('Location: index.php?page=admin-formations');
                exit;
            }
        }

        $this->render('formation-form', [
            'id'         => $id,
            'old'        => $old,
            'errors'     => $errors,
            'categories' => CategorieFormation::all(),   // pour la liste déroulante
        ]);
    }

    /** Validation PHP côté serveur : renvoie un tableau [champ => message d'erreur] */
    private function valider(array $d, int $id): array
    {
        $errors = [];

        // Titre
        if ($d['titre'] === '') {
            $errors['titre'] = 'Le titre est obligatoire.';
        } elseif (mb_strlen($d['titre']) < 3 || mb_strlen($d['titre']) > 150) {
            $errors['titre'] = 'Le titre doit contenir entre 3 et 150 caractères.';
        }

        // Catégorie : elle doit exister dans la base
        $idCat = (int) $d['id_categorie_formation'];
        if ($idCat <= 0 || CategorieFormation::find($idCat) === false) {
            $errors['id_categorie_formation'] = 'Choisissez une catégorie valide.';
        } elseif (!isset($errors['titre']) && Formation::titreExiste($d['titre'], $idCat, $id)) {
            $errors['titre'] = 'Une formation avec ce titre existe déjà dans cette catégorie.';
        }

        // Niveau et mode : uniquement les valeurs prévues par la base (ENUM)
        if (!in_array($d['niveau'], self::NIVEAUX, true)) {
            $errors['niveau'] = 'Niveau invalide.';
        }
        if (!in_array($d['mode'], self::MODES, true)) {
            $errors['mode'] = 'Mode invalide.';
        }

        // Durée : entier entre 1 et 500
        $duree = filter_var($d['duree_heures'], FILTER_VALIDATE_INT);
        if ($duree === false || $duree < 1 || $duree > 500) {
            $errors['duree_heures'] = 'La durée doit être un nombre entier entre 1 et 500 heures.';
        }

        // Prix : nombre positif ou nul (0 = gratuite)
        if (!is_numeric($d['prix']) || (float) $d['prix'] < 0) {
            $errors['prix'] = 'Le prix doit être un nombre positif ou nul.';
        }

        // Date de début : facultative, format AAAA-MM-JJ ;
        // règle métier : pas dans le passé pour une NOUVELLE formation
        if ($d['date_debut'] !== '') {
            $date = \DateTime::createFromFormat('Y-m-d', $d['date_debut']);
            if ($date === false || $date->format('Y-m-d') !== $d['date_debut']) {
                $errors['date_debut'] = 'Date invalide.';
            } elseif ($id === 0 && $date < new \DateTime('today')) {
                $errors['date_debut'] = 'La date de début ne peut pas être dans le passé.';
            }
        }

        if (mb_strlen($d['description']) > 2000) {
            $errors['description'] = 'La description ne doit pas dépasser 2000 caractères.';
        }

        return $errors;
    }
}
