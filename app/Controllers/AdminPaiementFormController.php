<?php

namespace App\Controllers;

class AdminPaiementFormController extends Controller
{
    protected string $page = 'admin-paiement-form';
    protected string $title = 'Modifier un paiement | Mahara Admin';

    public function index(): void
    {
        $this->render('paiement-form');
    }
}
