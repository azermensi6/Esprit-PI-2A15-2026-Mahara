<?php

namespace App\Controllers;

class InscriptionController extends Controller
{
    public function index(): void
    {
        $this->renderFront('inscription');
    }
}
