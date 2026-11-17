<?php

namespace App\Controllers;

class AdminLitigeFormController extends Controller
{
    protected string $page = 'admin-litige-form';
    protected string $title = 'Traiter un litige | Mahara Admin';

    public function index(): void
    {
        $this->render('litige-form');
    }
}
