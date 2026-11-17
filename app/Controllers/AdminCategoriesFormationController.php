<?php

namespace App\Controllers;

class AdminCategoriesFormationController extends Controller
{
    protected string $page = 'admin-categories-formation';
    protected string $title = 'Catégories de formation | Mahara Admin';

    public function index(): void
    {
        $this->render('categories-formation');
    }
}
