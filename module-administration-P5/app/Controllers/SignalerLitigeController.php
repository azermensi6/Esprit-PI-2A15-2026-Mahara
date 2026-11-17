<?php

namespace App\Controllers;

class SignalerLitigeController extends Controller
{
    public function index(): void
    {
        $this->renderFront('signaler-litige');
    }
}
