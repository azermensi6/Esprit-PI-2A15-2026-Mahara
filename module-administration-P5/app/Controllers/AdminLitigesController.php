<?php

namespace App\Controllers;

class AdminLitigesController extends Controller
{
    protected string $page = 'admin-litiges';
    protected string $title = 'Litiges | Mahara Admin';

    public function index(): void
    {
        $this->render('litiges');
    }
}
