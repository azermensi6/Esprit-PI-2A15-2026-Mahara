<?php

namespace App\Controllers;

class AdminMissionsController extends Controller
{
    protected string $page = 'admin-missions';
    protected string $title = 'Missions | Mahara Admin';

    public function index(): void
    {
        $this->render('missions');
    }
}
