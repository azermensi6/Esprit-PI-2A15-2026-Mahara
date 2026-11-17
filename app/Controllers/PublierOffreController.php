<?php

namespace App\Controllers;

class PublierOffreController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('publier-offre');
        $this->renderFront('publier-offre');
    }
}
