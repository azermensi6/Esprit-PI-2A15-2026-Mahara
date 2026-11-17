<?php

namespace App\Controllers;

class OffresController extends Controller
{
    public function index(): void
    {
        $this->renderFront('offres');
    }
}
