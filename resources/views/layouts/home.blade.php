<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>A We Green Enterprise — @yield('title')</title>
    @hasSection('meta-description')
        <meta name="description" content="@yield('meta-description')" />
    @endif
    {{-- ========== COMPANY LOGO ========== --}}
    <link rel="icon" type="image/png" href="{{ asset('css/images/AWeGreen-Logo.svg') }}">
    {{-- ========== BOOTSTRAP LINK ========== --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    {{-- ========== MATERIAL SYMBOLS LINK ========== --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    {{-- ========== CSS LINK (shared across admin, client, and landing) ========== --}}
    <link rel="stylesheet" href="{{ asset('css/utilities/utilities.css') }}" />
    @yield('styles')
</head>

<body class="@yield('body-class')">

    @include('includes.toast')

    @yield('content')

    {{-- ========== BOOTSTRAP JS ========== --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- ========== BOOTSTRAP FORM VALIDATION ========== --}}
    <script>
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

    @yield('scripts')
</body>

</html>
