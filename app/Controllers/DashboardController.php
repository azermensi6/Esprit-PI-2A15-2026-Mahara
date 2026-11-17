<?php

namespace App\Controllers;

class DashboardController extends Controller
{
    protected string $page = 'dashboard';
    protected string $title = 'Tableau de bord | Mahara Admin';

    public function index(): void
    {
        $this->render('dashboard');
    }
}
