<?php

namespace App\Units\Core\Http\Controllers;

use App\Support\Http\Controller;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}
