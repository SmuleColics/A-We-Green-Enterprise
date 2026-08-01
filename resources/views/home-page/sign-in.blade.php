@extends('layouts.home')

@section('title', 'Sign In')

@section('body-class', 'auth-page')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home-page/sign-in.css') }}" />
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
        <a href="{{ route('landing-page') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none">
          <img src="{{ asset('css/images/AWeGreen-Logo.svg') }}" alt="A We Green Enterprise" class="visual-logo" />
          <div>
            <div class="visual-brand-name">A We Green</div>
            <div class="visual-brand-sub">ENTERPRISE</div>
          </div>
        </a>
      </div>

      <!-- Headline + stats -->
      <div class="mw-500">
        <h2 class="visual-headline fs-46">
          Welcome back to a safer, greener future.
        </h2>
        <p class="visual-subtext mt-3 fs-18">
          Manage your projects, view installations, and stay connected with our team — all in one place.
        </p>

        <div class="row g-3 mt-2">
          <div class="col-4">
            <div class="login-stat-card p-4">
              <div class="login-stat-value">5,000+</div>
              <div class="login-stat-label">Cameras</div>
            </div>
          </div>
          <div class="col-4">
            <div class="login-stat-card p-4">
              <div class="login-stat-value">800+</div>
              <div class="login-stat-label">Solar Lights</div>
            </div>
          </div>
          <div class="col-4">
            <div class="login-stat-card p-4">
              <div class="login-stat-value">12 yrs</div>
              <div class="login-stat-label">Excellence</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Copyright -->
      <p class="visual-copyright mb-0 fs-14">
        © <span id="login-year"></span> A We Green Enterprise
      </p>

    </div>
  </div>

  <!-- ========== RIGHT — FORM SIDE ========== -->
  <div class="auth-form-side">

    <div class="auth-back">
      <a href="{{ route('landing-page') }}" class="back-link">
        <i class="bi bi-arrow-left me-1"></i> Back to home
      </a>
    </div>

    <div class="auth-form-center">
      <div class="auth-form-inner">

        <!-- Mobile logo -->
        <div class="d-flex d-lg-none align-items-center gap-2 mb-4">
          <img class="hpx-40" src="{{ asset('css/images/AWeGreen-Logo.svg') }}" alt="A We Green Enterprise">
        </div>

        <h1 class="auth-title">Sign in to your account</h1>
        <p class="auth-subtitle">Enter your credentials to continue.</p>

        <form class="mt-4" method="POST" action="">

          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label auth-label">Email address</label>
            <div class="input-icon-wrap">
              <i class="bi bi-envelope input-icon"></i>
              <input id="email" name="email" type="email" class="form-control auth-input ps-input"
                     placeholder="you@example.com" autocomplete="email" />
            </div>
          </div>

          <!-- Password -->
          <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label for="password" class="form-label auth-label mb-0">Password</label>
              <a href="{{ route('forgot-password') }}" class="forgot-link">Forgot password?</a>
            </div>
            <div class="input-icon-wrap">
              <i class="bi bi-lock input-icon"></i>
              <input id="password" name="password" type="password" class="form-control auth-input ps-input pe-input"
                     placeholder="••••••••" autocomplete="current-password" />
              <button type="button" class="password-toggle" id="togglePassword" aria-label="Show password">
                <i class="bi bi-eye" id="toggleIcon"></i>
              </button>
            </div>
          </div>

          <!-- Remember me -->
          <div class="mb-4">
            <div class="form-check auth-check">
              <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" />
              <label class="form-check-label auth-check-label" for="rememberMe">
                Keep me signed in
              </label>
            </div>
          </div>

          <button type="submit" class="btn w-100 auth-submit">Sign In</button>

        </form>

        <p class="text-center mt-4 auth-switch">
          Don't have an account?
          <a href="{{ route('register') }}" class="auth-link fw-semibold">Create one</a>
        </p>

      </div>
    </div>
  </div>

</div>

@endsection

@section('scripts')
<script>
  document.getElementById('login-year').textContent = new Date().getFullYear();

  /* Password toggle */
  const toggleBtn  = document.getElementById('togglePassword');
  const toggleIcon = document.getElementById('toggleIcon');
  const pwInput    = document.getElementById('password');

  toggleBtn.addEventListener('click', () => {
    const isPassword = pwInput.type === 'password';
    pwInput.type     = isPassword ? 'text' : 'password';
    toggleIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
    toggleBtn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
  });
</script>
@endsection