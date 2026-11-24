<?php

namespace App\Controllers;

use App\Models\Formation;

class FormationDetailController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('formation-detail');

        // ?id=3 dans l'URL ; si la formation n'existe pas, retour à la liste
        $formation = Formation::find((int) ($_GET['id'] ?? 0));
        if ($formation === false) {
            header('Location: index.php?page=formations');
            exit;
        }

        $this->renderFront('formation-detail', ['formation' => $formation]);
    }
}
