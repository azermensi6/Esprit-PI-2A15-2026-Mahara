<?php

namespace App\Controllers;

class AdminPaiementsController extends Controller
{
    protected string $page = 'admin-paiements';
    protected string $title = 'Paiements | Mahara Admin';

    public function index(): void
    {
        $this->render('paiements');
    }
}
