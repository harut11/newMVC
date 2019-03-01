<?php

namespace app\Controllers;

use root\forValidation;

class HomeController extends forValidation
{
    public function index()
    {
        echo view('home.index', 'Welcome to home page!');
    }
}