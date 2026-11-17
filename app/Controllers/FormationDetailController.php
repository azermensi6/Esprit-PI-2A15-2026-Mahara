<?php

namespace App\Controllers;

class FormationDetailController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('formation-detail');
        $this->renderFront('formation-detail');
    }
}
