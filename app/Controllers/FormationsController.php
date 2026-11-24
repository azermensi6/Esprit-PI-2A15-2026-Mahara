<?php

namespace App\Controllers;

use App\Models\CategorieFormation;
use App\Models\Formation;

class FormationsController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('formations');

        // Lecture et nettoyage des filtres reçus dans l'URL (méthode GET)
        $niveauxValides = ['debutant', 'intermediaire', 'avance'];
        $modesValides   = ['en_ligne', 'presentiel', 'hybride'];

        $prixMax = trim($_GET['prix_max'] ?? '');
        if ($prixMax !== '' && (!is_numeric($prixMax) || (float) $prixMax < 0)) {
            $prixMax = '';                                   // valeur invalide : on ignore le filtre
        }

        $mode = $_GET['mode'] ?? '';
        $tri  = $_GET['tri'] ?? 'date';

        $filtres = [
            'q'         => trim($_GET['q'] ?? ''),
            'categorie' => (int) ($_GET['categorie'] ?? 0),
            'niveaux'   => array_values(array_intersect((array) ($_GET['niveau'] ?? []), $niveauxValides)),
            'mode'      => in_array($mode, $modesValides, true) ? $mode : '',
            'prix_max'  => $prixMax,
        ];
        $tri = in_array($tri, ['date', 'prix', 'duree'], true) ? $tri : 'date';

        $this->renderFront('formations', [
            'formations' => Formation::search($filtres, $tri),
            'categories' => CategorieFormation::all(),
            'filtres'    => $filtres,
            'tri'        => $tri,
        ]);
    }
}
