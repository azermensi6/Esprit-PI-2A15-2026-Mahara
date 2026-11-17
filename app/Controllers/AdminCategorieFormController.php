<?php

namespace App\Controllers;

class AdminCategorieFormController extends Controller
{
    protected string $page = 'admin-categorie-form';
    protected string $title = 'Ajouter une catégorie | Mahara Admin';

    public function index(): void
    {
        $this->render('categorie-form');
    }
}
