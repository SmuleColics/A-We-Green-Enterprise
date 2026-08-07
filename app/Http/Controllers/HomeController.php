<?php

namespace App\Http\Controllers;

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

    public function showResetPassword()
    {
        return view('home-page.reset-password');
    }
}
