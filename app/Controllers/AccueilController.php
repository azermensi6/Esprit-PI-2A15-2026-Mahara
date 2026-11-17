<?php

namespace App\Controllers;

class AccueilController extends Controller
{
    public function index(): void
    {
        $this->renderFront('accueil');
    }
}
