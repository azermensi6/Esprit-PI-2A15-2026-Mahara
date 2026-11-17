<?php

namespace App\Controllers;

class AdminCategorieFormationFormController extends Controller
{
    protected string $page = 'admin-categorie-formation-form';
    protected string $title = 'Ajouter une catégorie de formation | Mahara Admin';

    public function index(): void
    {
        $this->render('categorie-formation-form');
    }
}
