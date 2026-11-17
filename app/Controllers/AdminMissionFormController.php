<?php

namespace App\Controllers;

class AdminMissionFormController extends Controller
{
    protected string $page = 'admin-mission-form';
    protected string $title = 'Ajouter une mission | Mahara Admin';

    public function index(): void
    {
        $this->render('mission-form');
    }
}
