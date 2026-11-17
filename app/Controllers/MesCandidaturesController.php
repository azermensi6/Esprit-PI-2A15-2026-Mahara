<?php

namespace App\Controllers;

class MesCandidaturesController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('mes-candidatures');
        $this->renderFront('mes-candidatures');
    }
}
