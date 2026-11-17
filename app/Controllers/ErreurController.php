<?php

namespace App\Controllers;

class ErreurController extends Controller
{
    public function index(): void
    {
        $this->renderFront('404');
    }
}
