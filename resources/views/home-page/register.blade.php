@extends('layouts.home')

@section('title', 'Register')

@section('body-class', 'auth-page')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home-page/register.css') }}" />
@endsection

@section('content')

  <div class="auth-wrapper">

    <!-- ========== LEFT — FORM SIDE ========== -->
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

          <h1 class="auth-title">Create your account</h1>
          <p class="auth-subtitle">
            Join A We Green to manage your installations and assessments.
          </p>

         <form class="mt-4 needs-validation" method="POST" action="{{ route('register.store') }}" novalidate>
            @csrf

            <!-- First + Last name -->
            <div class="row g-3 mb-3">
              <div class="col-sm-6">
                <label for="firstName" class="form-label auth-label">First name</label>
                <div class="input-icon-wrap">
                  <i class="bi bi-person input-icon"></i>
                  <input id="firstName" name="first_name" type="text" value="{{ old('first_name') }}" class="form-control auth-input ps-input" placeholder="Juan" required />
                </div>
                <div class="invalid-feedback">Please enter your first name.</div>
              </div>
              <div class="col-sm-6">
                <label for="lastName" class="form-label auth-label">Last name</label>
                <input id="lastName" name="last_name" type="text" value="{{ old('last_name') }}" class="form-control auth-input" placeholder="Dela Cruz" required />
                <div class="invalid-feedback">Please enter your last name.</div>
              </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label auth-label">Email address</label>
              <div class="input-icon-wrap">
                <i class="bi bi-envelope input-icon"></i>
                <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control auth-input ps-input" placeholder="you@example.com" required />
              </div>
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>

            <!-- Phone -->
            <div class="mb-3">
              <label for="phone" class="form-label auth-label">Phone Number</label>

              <div class="input-icon-wrap">
                  <i class="bi bi-telephone input-icon"></i>

                  <input
                      id="phone"
                      name="contact_number"
                      type="tel"
                      class="form-control auth-input ps-input"
                      value="{{ old('contact_number') }}"
                      placeholder="09171234567"
                      pattern="^09\d{9}$"
                      required>
              </div>

              <div class="invalid-feedback">
                  Please enter a valid Philippine mobile number.
              </div>
          </div>

            <!-- Password -->
            <div class="mb-3">
              <label for="password" class="form-label auth-label">Password</label>
              <div class="input-icon-wrap">
                <i class="bi bi-lock input-icon"></i>
                <input id="password" name="password" type="password" class="form-control auth-input ps-input pe-input" placeholder="At least 8 characters" minlength="8" required />
                <button type="button" class="password-toggle" id="togglePassword" aria-label="Show password">
                  <i class="bi bi-eye" id="toggleIcon"></i>
                </button>
              </div>
              <div class="invalid-feedback">Password must be at least 8 characters.</div>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
              <label for="password_confirmation" class="form-label auth-label">Confirm password</label>
              <div class="input-icon-wrap">
                <i class="bi bi-lock input-icon"></i>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control auth-input ps-input" placeholder="Re-enter your password" required />
              </div>
              <div class="invalid-feedback">Please confirm your password.</div>
            </div>

            <!-- Terms -->
            <div class="mb-4">
              <div class="form-check auth-check">
                <input class="form-check-input" type="checkbox" id="agreeTerms" name="agree_terms" required />
                <label class="form-check-label auth-check-label" for="agreeTerms">
                  I agree to the <a href="#" class="auth-link" data-bs-toggle="modal" data-bs-target="#termsModal">Terms of Service</a> and <a href="#" class="auth-link" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a>.
                </label>
              </div>
              <div class="invalid-feedback">You must agree before creating an account.</div>
            </div>

            <button type="submit" class="btn w-100 auth-submit">Create Account</button>

          </form>

          <p class="text-center mt-4 auth-switch">
            Already have an account? <a href="{{ route('sign-in') }}" class="auth-link fw-semibold">Sign in</a>
          </p>

        </div>
      </div>
    </div>

    <!-- ========== RIGHT — VISUAL SIDE ========== -->
    <div class="auth-visual-side d-none d-lg-flex">

      <img src="{{ asset('css/images/hero-img.jpg') }}" alt="Solar and CCTV installations" class="auth-visual-bg" />
      <div class="auth-visual-overlay"></div>

      <div class="auth-visual-content d-flex flex-column justify-content-between h-100 position-relative">

        <!-- Logo top right -->
        <div class="d-flex justify-content-end">
          <a href="{{ route('landing-page') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none">
            <img src="{{ asset('css/images/AWeGreen-Logo.svg') }}" alt="A We Green Enterprise" class="visual-logo" />
            <div>
              <div class="visual-brand-name">A We Green</div>
              <div class="visual-brand-sub">ENTERPRISE</div>
            </div>
          </a>
        </div>

        <!-- Headline + perks -->
        <div class="mw-600">
          <h2 class="visual-headline fs-46">
            Join hundreds of clients securing what matters most.
          </h2>
          <p class="visual-subtext mt-3">
            From CCTV surveillance to solar energy — A We Green has been the trusted
            partner of LGUs and businesses since 2014.
          </p>

          <ul class="list-unstyled mt-4 d-flex flex-column gap-3">
            <li class="d-flex align-items-center gap-3">
              <span class="perk-icon">
                <i class="bi bi-shield-check perk-icon-i"></i>
              </span>
              <span class="perk-label">Track your CCTV &amp; security projects</span>
            </li>
            <li class="d-flex align-items-center gap-3">
              <span class="perk-icon">
                <i class="bi bi-lightning-charge perk-icon-i"></i>
              </span>
              <span class="perk-label">Monitor solar installation progress</span>
            </li>
            <li class="d-flex align-items-center gap-3">
              <span class="perk-icon">
                <i class="bi bi-headset perk-icon-i"></i>
              </span>
              <span class="perk-label">Priority support from our team</span>
            </li>
          </ul>
        </div>

        <!-- Copyright -->
        <p class="visual-copyright mb-0 fs-14">
          © <span id="reg-year"></span> A We Green Enterprise
        </p>

      </div>
    </div>

  </div>


  <!-- ========== TERMS OF SERVICE MODAL ========== -->
  <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-semibold" id="termsModalLabel">Terms of Service</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body dblue-text fs-15 lh-17">

          <p class="text-muted fs-13">Last updated: January 1, 2025</p>

          <h6 class="fw-semibold amt-4 mb-2">1. Acceptance of Terms</h6>
          <p>By creating an account and using the A We Green Enterprise platform ("Service"), you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use the Service.</p>

          <h6 class="fw-semibold mt-4 mb-2">2. Use of the Service</h6>
          <p>The Service is intended for clients and partners of A We Green Enterprise to monitor and manage their CCTV, security, and solar installation projects. You agree to use the Service only for lawful purposes and in accordance with these Terms.</p>
          <ul>
            <li>You must have the legal capacity to agree to these Terms. If you are using the Service on behalf of another person or organization, you confirm that you are authorized to do so.</li>
            <li>You are responsible for maintaining the confidentiality of your login credentials.</li>
            <li>You agree not to share your account with any third party.</li>
          </ul>

          <h6 class="fw-semibold mt-4 mb-2">3. Account Registration</h6>
          <p>You agree to provide accurate, current, and complete information during registration and to update such information to keep it accurate. A We Green Enterprise reserves the right to suspend or terminate accounts with inaccurate information.</p>

          <h6 class="fw-semibold mt-4 mb-2">4. Intellectual Property</h6>
          <p>All content, trademarks, logos, and data on this platform are the property of A We Green Enterprise or its licensors. You may not reproduce, distribute, or create derivative works without our express written permission.</p>

          <h6 class="fw-semibold mt-4 mb-2">5. Limitation of Liability</h6>
          <p>A We Green Enterprise shall not be liable for any indirect, incidental, or consequential damages arising from your use of the Service. Our total liability shall not exceed the amount paid by you, if any, for access to the Service.</p>

          <h6 class="fw-semibold mt-4 mb-2">6. Termination</h6>
          <p>We reserve the right to suspend or terminate your access to the Service at our sole discretion, without notice, for conduct that we believe violates these Terms or is harmful to other users, us, or third parties.</p>

          <h6 class="fw-semibold mt-4 mb-2">7. Changes to Terms</h6>
          <p>We may update these Terms from time to time. Continued use of the Service after changes are posted constitutes your acceptance of the revised Terms.</p>

          <h6 class="fw-semibold mt-4 mb-2">8. Contact Us</h6>
          <p class="mb-0">For questions about these Terms, contact us at <a href="mailto:support@awegreenenterprise.com" class="auth-link">support@awegreenenterprise.com</a>.</p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ========== PRIVACY POLICY MODAL ========== -->
  <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-semibold" id="privacyModalLabel">Privacy Policy</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body dblue-text fs-15 lh-17">

          <p class="text-muted fs-13">Last updated: January 1, 2025</p>

          <p>A We Green Enterprise ("we", "us", or "our") is committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you use our platform.</p>

          <h6 class="fw-semibold mt-4 mb-2">1. Information We Collect</h6>
          <p>We collect information you provide directly to us when registering or using the Service, including:</p>
          <ul>
            <li>Full name, email address, and phone number</li>
            <li>Account credentials (stored securely, passwords are hashed)</li>
            <li>Project-related communications and support requests</li>
            <li>Usage data and device/browser information for analytics</li>
          </ul>

          <h6 class="fw-semibold mt-4 mb-2">2. How We Use Your Information</h6>
          <p>We use the information collected to:</p>
          <ul>
            <li>Create and manage your account</li>
            <li>Provide project tracking and monitoring features</li>
            <li>Send service-related notifications and updates</li>
            <li>Respond to support inquiries</li>
            <li>Improve and secure the platform</li>
          </ul>

          <h6 class="fw-semibold mt-4 mb-2">3. Sharing of Information</h6>
          <p>We do not sell or rent your personal information to third parties. We may share data with trusted service providers who assist in operating our platform, subject to confidentiality agreements. We may also disclose information if required by law.</p>

          <h6 class="fw-semibold mt-4 mb-2">4. Data Security</h6>
          <p>We implement industry-standard security measures including encryption, access controls, and regular audits to protect your information. However, no method of transmission over the internet is 100% secure.</p>

          <h6 class="fw-semibold mt-4 mb-2">5. Data Retention</h6>
          <p>We retain your personal data for as long as your account is active or as needed to provide services. You may request deletion of your account and associated data by contacting us.</p>

          <h6 class="fw-semibold mt-4 mb-2">6. Your Rights</h6>
          <p>Under applicable Philippine data privacy laws (Republic Act No. 10173), you have the right to access, correct, or request deletion of your personal data. To exercise these rights, contact our Data Protection Officer.</p>

          <h6 class="fw-semibold mt-4 mb-2">7. Cookies</h6>
          <p>We use cookies and similar technologies to maintain sessions and improve user experience. You may disable cookies in your browser settings, though some features may not function properly as a result.</p>

          <h6 class="fw-semibold mt-4 mb-2">8. Contact Us</h6>
          <p class="mb-0">For privacy-related concerns, reach us at <a href="mailto:privacy@awegreenenterprise.com" class="auth-link">privacy@awegreenenterprise.com</a>.</p>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
  <script>
    document.getElementById('reg-year').textContent = new Date().getFullYear();

    const toggleBtn = document.getElementById('togglePassword');
    const toggleIcon = document.getElementById('toggleIcon');
    const pwInput = document.getElementById('password');

    toggleBtn.addEventListener('click', () => {
      const isPassword = pwInput.type === 'password';
      pwInput.type = isPassword ? 'text' : 'password';
      toggleIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
      toggleBtn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
    });
  </script>
@endsection