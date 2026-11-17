<?php

namespace App\Controllers;

class AdminFormationFormController extends Controller
{
    protected string $page = 'admin-formation-form';
    protected string $title = 'Ajouter une formation | Mahara Admin';

    public function index(): void
    {
        $this->render('formation-form');
    }
}
