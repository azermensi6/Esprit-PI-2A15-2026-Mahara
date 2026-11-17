<?php

namespace App\Controllers;

class PortfolioController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('portfolio');
        $this->renderFront('portfolio');
    }
}
