@extends('layouts.home')

@section('title', 'Forgot Password')

@section('body-class', 'auth-page')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home-page/sign-in.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/home-page/forgot-password.css') }}" />
@endsection

@section('content')

    <div class="auth-wrapper">

        <!-- ========== LEFT — VISUAL SIDE ========== -->
        <div class="login-visual-side d-none d-lg-flex">

            <img src="{{ asset('css/images/hero-img.jpg') }}" alt="Solar and CCTV installations" class="auth-visual-bg" />
            <div class="login-visual-overlay"></div>

            <div class="login-visual-content d-flex flex-column justify-content-between h-100 position-relative">

                <!-- Logo top left -->
                <div>
                    <a href="{{ route('landing-page') }}"
                        class="d-inline-flex align-items-center gap-2 text-decoration-none">
                        <img src="{{ asset('css/images/AWeGreen-Logo.svg') }}" alt="A We Green Enterprise"
                            class="visual-logo" />
                        <div>
                            <div class="visual-brand-name">A We Green</div>
                            <div class="visual-brand-sub">ENTERPRISE</div>
                        </div>
                    </a>
                </div>

                <!-- Headline + reassurance -->
                <div class="mw-500">
                    <h2 class="visual-headline fs-42">
                        Let's get you back in.
                    </h2>
                    <p class="visual-subtext mt-3" style="font-size: 1.05rem;">
                        It happens to the best of us. Enter your email and we'll send you a link to reset your password and
                        get back to managing your projects.
                    </p>

                    <ul class="list-unstyled mt-4 d-flex flex-column gap-3">
                        <li class="d-flex align-items-center gap-3">
                            <span class="perk-icon text-white">
                                <i class="bi bi-shield-lock perk-icon-i"></i>
                            </span>
                            <span class="perk-label text-white">Your account stays secure the whole time</span>
                        </li>
                        <li class="d-flex align-items-center gap-3">
                            <span class="perk-icon text-white">
                                <i class="bi bi-envelope-check perk-icon-i"></i>
                            </span>
                            <span class="perk-label text-white">Reset link expires after 60 minutes</span>
                        </li>
                    </ul>
                </div>

                <!-- Copyright -->
                <p class="visual-copyright mb-0" style="font-size: 14px;">
                    © <span id="fp-year"></span> A We Green Enterprise
                </p>

            </div>
        </div>

        <!-- ========== RIGHT — FORM SIDE ========== -->
        <div class="auth-form-side">

            <div class="auth-back">
                <a href="{{ route('sign-in') }}" class="back-link">
                    <i class="bi bi-arrow-left me-1"></i> Back to sign in
                </a>
            </div>

            <div class="auth-form-center">
                <div class="auth-form-inner">

                    <!-- Mobile logo -->
                    <div class="d-flex d-lg-none align-items-center gap-2 mb-4">
                        <img class="hpx-40" src="{{ asset('css/images/AWeGreen-Logo.svg') }}" alt="A We Green Enterprise">
                    </div>

                    <!-- ── STATE 1: REQUEST FORM (default view) ── -->
                    <div id="fp-request-view" @if (session('success')) class="d-none" @endif>

                        <div class="fp-icon-badge mb-3">
                            <span class="material-symbols-outlined">lock_reset</span>
                        </div>

                        <h1 class="auth-title">Forgot your password?</h1>
                        <p class="auth-subtitle">No worries. Enter the email linked to your account and we'll send you a
                            reset link.</p>

                        <form class="mt-4 needs-validation" method="POST" action="{{ route('forgot-password.store') }}"
                            id="fp-form" novalidate>
                            @csrf

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label auth-label">Email address</label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-envelope input-icon"></i>
                                    <input id="email" name="email" type="email" value="{{ old('email') }}"
                                        class="form-control auth-input ps-input" placeholder="you@example.com"
                                        autocomplete="email" required />
                                </div>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>

                            <button type="submit"
                                class="btn w-100 auth-submit d-flex align-items-center justify-content-center">
                                Send Reset Link
                            </button>

                        </form>

                        <p class="text-center mt-4 auth-switch">
                            Remembered your password?
                            <a href="{{ route('sign-in') }}" class="auth-link fw-semibold">Sign in</a>
                        </p>

                    </div>

                    <!-- ── STATE 2: CONFIRMATION (shown after submit) ── -->
                    <div id="fp-sent-view" class="@unless (session('success')) d-none @endunless">

                        <div class="fp-icon-badge fp-icon-badge--success mb-3">
                            <span class="material-symbols-outlined">mark_email_read</span>
                        </div>

                        <h1 class="auth-title">Check your email</h1>
                        <p class="auth-subtitle">
                            We've sent a password reset link to <strong
                                id="fp-sent-email">{{ old('email', 'your email') }}</strong>.
                            The link will expire in 60 minutes.
                        </p>

                        <div class="fp-resend-box mt-4">
                            <p class="mb-2">Didn't get the email? Check your spam folder, or</p>
                            <a href="{{ route('forgot-password') }}" class="btn-link-plain">try again</a>
                        </div>

                        <a href="{{ route('sign-in') }}"
                            class="btn w-100 auth-submit mt-4 d-inline-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-arrow-left"></i> Back to Sign In
                        </a>

                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script>
        document.getElementById('fp-year').textContent = new Date().getFullYear();

        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
@endsection
