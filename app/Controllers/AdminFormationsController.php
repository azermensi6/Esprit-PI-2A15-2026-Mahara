<?php

namespace App\Controllers;

class AdminFormationsController extends Controller
{
    protected string $page = 'admin-formations';
    protected string $title = 'Formations | Mahara Admin';

    public function index(): void
    {
        $this->render('formations');
    }
}
