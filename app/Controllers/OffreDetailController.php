<?php

namespace App\Controllers;

class OffreDetailController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('offre-detail');
        $this->renderFront('offre-detail');
    }
}
