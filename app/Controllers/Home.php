<?php

namespace App\Controllers;

class Home extends BaseAuthController
{
    public function index(): string
    {
        return view('welcome_message');
    }
  public function dashboard()
    {
      return view('dashboard');
    }
}
