<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function showLandingPage()
  {
    return view('home-page.landing-page');
  }

  public function showSignIn()
  {
    return view('home-page.sign-in');
  }

  public function showRegister()
  {
    return view('home-page.register');
  }

  public function showForgotPassword()
  {
    return view('home-page.forgot-password');
  }
}
