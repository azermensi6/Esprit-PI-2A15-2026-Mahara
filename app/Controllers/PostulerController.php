<?php

namespace App\Controllers;

class PostulerController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('postuler');
        $this->renderFront('postuler');
    }
}
