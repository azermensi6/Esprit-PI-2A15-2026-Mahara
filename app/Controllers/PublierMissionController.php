<?php

namespace App\Controllers;

class PublierMissionController extends Controller
{
    public function index(): void
    {
        $this->renderFront('publier-mission');
    }
}
