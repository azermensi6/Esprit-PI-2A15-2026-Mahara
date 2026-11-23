<?php

namespace App\Controllers;

use App\Models\Formation;

class AdminFormationsController extends Controller
{
    protected string $page = 'admin-formations';
    protected string $title = 'Formations | Mahara Admin';

    public function index(): void
    {
        // Suppression demandée depuis la liste (formulaire POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
            Formation::delete((int) $_POST['delete_id']);
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Formation supprimée.'];
            header('Location: index.php?page=admin-formations');
            exit;
        }

        // Message affiché une seule fois après une action
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        $this->render('formations', [
            'formations' => Formation::allWithCategorie(),
            'flash'      => $flash,
        ]);
    }
}
