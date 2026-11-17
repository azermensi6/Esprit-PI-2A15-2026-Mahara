<?php

namespace App\Controllers;

class AdminCompetenceFormController extends Controller
{
    protected string $page = 'admin-competence-form';
    protected string $title = 'Ajouter une compétence | Mahara Admin';

    public function index(): void
    {
        $this->render('competence-form');
    }
}
