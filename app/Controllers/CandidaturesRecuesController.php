<?php

namespace App\Controllers;

class CandidaturesRecuesController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('candidatures-recues');
        $this->renderFront('candidatures-recues');
    }
}
