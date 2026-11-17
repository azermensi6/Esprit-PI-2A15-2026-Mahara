<?php

namespace App\Controllers;

class MesMissionsController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('mes-missions');
        $this->renderFront('mes-missions');
    }
}
