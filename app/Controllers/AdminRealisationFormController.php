<?php

namespace App\Controllers;

class AdminRealisationFormController extends Controller
{
    protected string $page = 'admin-realisation-form';
    protected string $title = 'Modifier une réalisation | Mahara Admin';

    public function index(): void
    {
        $this->render('realisation-form');
    }
}
