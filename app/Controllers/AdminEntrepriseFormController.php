<?php

namespace App\Controllers;

class AdminEntrepriseFormController extends Controller
{
    protected string $page = 'admin-entreprise-form';
    protected string $title = 'Vérifier une entreprise | Mahara Admin';

    public function index(): void
    {
        $this->render('entreprise-form');
    }
}
