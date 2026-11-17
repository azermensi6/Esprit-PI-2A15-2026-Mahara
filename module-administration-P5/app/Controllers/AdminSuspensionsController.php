<?php

namespace App\Controllers;

class AdminSuspensionsController extends Controller
{
    protected string $page = 'admin-suspensions';
    protected string $title = 'Suspensions | Mahara Admin';

    public function index(): void
    {
        $this->render('suspensions');
    }
}
