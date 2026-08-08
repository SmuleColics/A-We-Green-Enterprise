<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>A We Green Enterprise — @yield('title')</title>
    {{-- ========== COMPANY LOGO ========== --}}
    <link rel="icon" type="image/png" href="{{ asset('css/images/AWeGreen-Logo.svg') }}">
    {{-- ========== BOOTSTRAP LINK ========== --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    {{-- ========== MATERIAL SYMBOLS LINK ========== --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    {{-- ========== CSS LINK ========== --}}
    <link rel="stylesheet" href="{{ asset('css/utilities/utilities.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/includes/client-nav.css') }}" />
    @yield('styles')
</head>

<body class="portal-body">

    @include('includes.client-nav')

    <main class="portal-main pb-5">
        @yield('content')
    </main>

    {{-- jquery script --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    {{-- bootstrap script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- client nav script (mobile drawer toggle) --}}
    <script src="{{ asset('js/client/client-nav.js') }}"></script>
    <script src="{{ asset('js/includes/toast.js') }}"></script>
    @yield('scripts')
</body>

</html>
