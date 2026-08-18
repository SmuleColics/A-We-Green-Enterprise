<?php

namespace App\Http\Controllers;

use App\Services\LandingContentService;

class HomeController extends Controller
{
    public function showLandingPage()
    {
        $heroStats = LandingContentService::heroStats();
        $statsBar = LandingContentService::statsBar();
        $landingServices = LandingContentService::services();
        $testimonials = LandingContentService::testimonials();

        return view('home-page.landing-page', compact('heroStats', 'statsBar', 'landingServices', 'testimonials'));
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
