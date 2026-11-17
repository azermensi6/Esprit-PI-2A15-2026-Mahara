<?php

namespace App\Controllers;

class DeconnexionController extends Controller
{
    public function index(): void
    {
        $_SESSION = [];
        session_destroy();
        header('Location: index.php?page=accueil');
        exit;
    }
}
