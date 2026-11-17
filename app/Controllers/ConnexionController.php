<?php

namespace App\Controllers;

class ConnexionController extends Controller
{
    public function index(): void
    {
        $this->renderFront('connexion');
    }
}
