<?php

namespace App\Controllers;

class MissionsController extends Controller
{
    public function index(): void
    {
        $this->renderFront('missions');
    }
}
