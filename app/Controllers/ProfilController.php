<?php

namespace App\Controllers;

class ProfilController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('profil');
        $this->renderFront('profil');
    }
}
