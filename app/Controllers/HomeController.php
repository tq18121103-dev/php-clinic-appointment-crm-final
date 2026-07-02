<?php

namespace App\Controllers;

class HomeController
{
    public function index(): void
    {
        if (is_logged_in()) {
            redirect('/dashboard');
        } else {
            redirect('/login');
        }
    }
}