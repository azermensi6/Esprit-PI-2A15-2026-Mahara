<?php

namespace App\Controllers;

class AdminUtilisateursController extends Controller
{
    protected string $page = 'admin-utilisateurs';
    protected string $title = 'Utilisateurs | Mahara Admin';

    public function index(): void
    {
        $this->render('utilisateurs');
    }
}
