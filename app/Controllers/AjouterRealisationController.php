<?php

namespace App\Controllers;

class AjouterRealisationController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('ajouter-realisation');
        $this->renderFront('ajouter-realisation');
    }
}
