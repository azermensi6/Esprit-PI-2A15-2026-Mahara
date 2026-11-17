<?php

namespace App\Controllers;

class AdminEntreprisesController extends Controller
{
    protected string $page = 'admin-entreprises';
    protected string $title = 'Entreprises | Mahara Admin';

    public function index(): void
    {
        $this->render('entreprises');
    }
}
