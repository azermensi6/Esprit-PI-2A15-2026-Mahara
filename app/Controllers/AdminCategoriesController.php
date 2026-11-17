<?php

namespace App\Controllers;

class AdminCategoriesController extends Controller
{
    protected string $page = 'admin-categories';
    protected string $title = 'Catégories | Mahara Admin';

    public function index(): void
    {
        $this->render('categories');
    }
}
