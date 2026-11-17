<?php

namespace App\Controllers;

class SigninController extends Controller
{
    protected string $page = 'signin';
    protected string $title = 'Connexion | Mahara Admin';

    public function index(): void
    {
        $this->renderStandalone('signin');
    }
}
