<?php

namespace App\Controllers;

class BlankPageController extends Controller
{
    protected string $page = 'blank-page';
    protected string $title = 'Page vide | Mahara Admin';

    public function index(): void
    {
        $this->render('blank-page');
    }
}
