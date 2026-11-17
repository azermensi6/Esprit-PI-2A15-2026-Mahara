<?php

namespace App\Controllers;

class AdminUtilisateurFormController extends Controller
{
    protected string $page = 'admin-utilisateur-form';
    protected string $title = 'Modifier un utilisateur | Mahara Admin';

    public function index(): void
    {
        $this->render('utilisateur-form');
    }
}
