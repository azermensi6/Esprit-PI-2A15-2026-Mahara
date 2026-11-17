<?php

namespace App\Controllers;

class PayerController extends Controller
{
    public function index(): void
    {
        $this->requireLogin('payer');
        $this->renderFront('payer');
    }
}
