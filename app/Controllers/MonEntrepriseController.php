<?php

namespace App\Controllers;

class MonEntrepriseController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('mon-entreprise');
        $this->renderFront('mon-entreprise');
    }
}
