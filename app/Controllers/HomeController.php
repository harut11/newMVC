<?php

namespace app\Controllers;

class HomeController
{
    public function index()
    {
        echo view('home.index', 'Welcome to home page!');
    }
}