<?php

namespace App\Controllers;

class PublierMissionController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('publier-mission');
        $this->renderFront('publier-mission');
    }
}
