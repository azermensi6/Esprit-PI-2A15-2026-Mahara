<?php

namespace App\Controllers;

class AdminCompetencesController extends Controller
{
    protected string $page = 'admin-competences';
    protected string $title = 'Compétences | Mahara Admin';

    public function index(): void
    {
        $this->render('competences');
    }
}
