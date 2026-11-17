<?php

namespace App\Controllers;

class AdminRealisationsController extends Controller
{
    protected string $page = 'admin-realisations';
    protected string $title = 'Réalisations | Mahara Admin';

    public function index(): void
    {
        $this->render('realisations');
    }
}
