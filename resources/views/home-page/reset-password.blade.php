@extends('layouts.home')

@section('title', 'Reset Password')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home-page/sign-in.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/home-page/reset-password.css') }}" />
@endsection

@section('body-class', 'auth-page')

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

      <!-- Headline + reassurance -->
      <div style="max-width:500px;">
        <h2 class="visual-headline" style="font-size: 42px;">
          Almost there.
        </h2>
        <p class="visual-subtext mt-3" style="font-size: 1.05rem;">
          Choose a new password to secure your account. Make it strong, and make it one you'll remember.
        </p>

        <ul class="list-unstyled mt-4 d-flex flex-column gap-3">
          <li class="d-flex align-items-center gap-3">
            <span class="perk-icon">
              <i class="bi bi-shield-check perk-icon-i text-white"></i>
            </span>
            <span class="perk-label text-white">At least 8 characters</span>
          </li>
          <li class="d-flex align-items-center gap-3">
            <span class="perk-icon">
              <i class="bi bi-key perk-icon-i text-white"></i>
            </span>
            <span class="perk-label text-white">Avoid reusing old passwords</span>
          </li>
        </ul>
      </div>

      <!-- Copyright -->
      <p class="visual-copyright mb-0" style="font-size: 14px;">
        © <span id="rp-year"></span> A We Green Enterprise
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
          <img src="{{ asset('css/images/AWeGreen-Logo.svg') }}" alt="A We Green Enterprise" style="height:40px;">
        </div>

        <div class="fp-icon-badge mb-3">
          <span class="material-symbols-outlined">password</span>
        </div>

        <h1 class="auth-title">Set a new password</h1>
        <p class="auth-subtitle">
            Your new password must be different from previously used passwords.
        </p>

        <form class="mt-4" method="POST" action="#">

          <!-- Hidden fields required by Laravel's password reset flow -->
          <input type="hidden" name="token" value="">
          <input type="hidden" name="email" value="">

          <!-- Email (read-only, shown for confirmation) -->
          <div class="mb-3">
            <label for="email-display" class="form-label auth-label">Email address</label>
            <div class="input-icon-wrap">
              <i class="bi bi-envelope input-icon"></i>
              <input id="email-display" type="email" class="form-control auth-input ps-input"
                     value="" disabled />
            </div>
          </div>

          <!-- New Password -->
          <div class="mb-3">
            <label for="password" class="form-label auth-label">New password</label>
            <div class="input-icon-wrap">
              <i class="bi bi-lock input-icon"></i>
              <input id="password" name="password" type="password" class="form-control auth-input ps-input pe-input"
                     placeholder="At least 8 characters" autocomplete="new-password" required />
              <button type="button" class="password-toggle" id="togglePassword" aria-label="Show password">
                <i class="bi bi-eye" id="toggleIcon"></i>
              </button>
            </div>
          </div>

          <!-- Confirm Password -->
          <div class="mb-4">
            <label for="password_confirmation" class="form-label auth-label">Confirm new password</label>
            <div class="input-icon-wrap">
              <i class="bi bi-lock-fill input-icon"></i>
              <input id="password_confirmation" name="password_confirmation" type="password"
                     class="form-control auth-input ps-input pe-input" placeholder="Re-enter your new password"
                     autocomplete="new-password" required />
              <button type="button" class="password-toggle" id="toggleConfirmPassword" aria-label="Show password">
                <i class="bi bi-eye" id="toggleConfirmIcon"></i>
              </button>
            </div>
          </div>

          <!-- Password strength hint -->
          <div class="fp-strength-hint mb-4">
            <p class="fp-strength-item" id="rule-length">
              <span class="material-symbols-outlined">radio_button_unchecked</span>
              At least 8 characters
            </p>
            <p class="fp-strength-item" id="rule-match">
              <span class="material-symbols-outlined">radio_button_unchecked</span>
              Passwords match
            </p>
          </div>

          <button type="submit" class="btn w-100 auth-submit">Reset Password</button>

        </form>

      </div>
    </div>
  </div>

</div>

@endsection

@section('scripts')
<script>
  document.getElementById('rp-year').textContent = new Date().getFullYear();

  /* Password toggle — new password field */
  const toggleBtn  = document.getElementById('togglePassword');
  const toggleIcon = document.getElementById('toggleIcon');
  const pwInput    = document.getElementById('password');

  toggleBtn.addEventListener('click', () => {
    const isPassword = pwInput.type === 'password';
    pwInput.type     = isPassword ? 'text' : 'password';
    toggleIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
    toggleBtn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
  });

  /* Password toggle — confirm field */
  const toggleConfirmBtn  = document.getElementById('toggleConfirmPassword');
  const toggleConfirmIcon = document.getElementById('toggleConfirmIcon');
  const pwConfirmInput    = document.getElementById('password_confirmation');

  toggleConfirmBtn.addEventListener('click', () => {
    const isPassword = pwConfirmInput.type === 'password';
    pwConfirmInput.type = isPassword ? 'text' : 'password';
    toggleConfirmIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
    toggleConfirmBtn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
  });

  /* Live validation hints — cosmetic only, real validation is server-side */
  const ruleLength = document.getElementById('rule-length');
  const ruleMatch  = document.getElementById('rule-match');

  function setRuleState(el, met) {
    const icon = el.querySelector('.material-symbols-outlined');
    icon.textContent = met ? 'check_circle' : 'radio_button_unchecked';
    el.classList.toggle('fp-rule-met', met);
  }

  function checkRules() {
    setRuleState(ruleLength, pwInput.value.length >= 8);
    setRuleState(ruleMatch, pwConfirmInput.value.length > 0 && pwInput.value === pwConfirmInput.value);
  }

  pwInput.addEventListener('input', checkRules);
  pwConfirmInput.addEventListener('input', checkRules);
</script>
@endsection