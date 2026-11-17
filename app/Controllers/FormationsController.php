<?php

namespace App\Controllers;

class FormationsController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('formations');
        $this->renderFront('formations');
    }
}
