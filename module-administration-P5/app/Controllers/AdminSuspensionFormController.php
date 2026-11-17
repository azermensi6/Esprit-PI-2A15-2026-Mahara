<?php

namespace App\Controllers;

class AdminSuspensionFormController extends Controller
{
    protected string $page = 'admin-suspension-form';
    protected string $title = 'Ajouter une suspension | Mahara Admin';

    public function index(): void
    {
        $this->render('suspension-form');
    }
}
