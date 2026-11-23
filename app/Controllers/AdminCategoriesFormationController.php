<?php

namespace App\Controllers;

use App\Models\CategorieFormation;

class AdminCategoriesFormationController extends Controller
{
    protected string $page = 'admin-categories-formation';
    protected string $title = 'Catégories de formation | Mahara Admin';

    public function index(): void
    {
        // Suppression demandée depuis la liste (bouton « Supprimer » dans un formulaire POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
            $this->supprimer((int) $_POST['delete_id']);
        }

        // Message affiché une seule fois après une action (ajout, modification, suppression)
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        $this->render('categories-formation', [
            'categories' => CategorieFormation::allWithCount(),
            'flash'      => $flash,
        ]);
    }

    private function supprimer(int $id): void
    {
        // Règle métier : on ne supprime pas une catégorie qui contient des formations
        if (CategorieFormation::countFormations($id) > 0) {
            $_SESSION['flash'] = ['type' => 'danger',
                'message' => 'Suppression impossible : cette catégorie contient encore des formations.'];
        } else {
            CategorieFormation::delete($id);
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Catégorie supprimée.'];
        }
        header('Location: index.php?page=admin-categories-formation');
        exit;
    }
}
