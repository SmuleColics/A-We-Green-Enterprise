<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> A We Green Enterprise — @yield('title')</title>
    {{-- ========== COMPANY LOGO ========== --}}
    <link rel="icon" type="image/png" href="{{ asset('css/images/AWeGreen-Logo.svg') }}">
    {{-- ========== BOOTSTRAP LINK ========== --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    {{-- ========== MATERIAL SYMBOLS LINK ========== --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    {{-- ========== CSSS LINK ========== --}}
    <link rel="stylesheet" href="{{ asset('css/utilities/utilities.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/includes/sidebar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}" />
    @yield('styles')
</head>

<body class="bg-awg-light">
    @include('includes.toast')

    <div class="admin-layout bg-awg-light">
        @include('includes.sidebar')
        @include('includes.topbar')

        <main class="admin-content flex-grow-1 p-1">
            @yield('content')
        </main>
    </div>

    {{-- jquery script --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    {{-- datatables script --}}
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $('.modal').on('hidden.bs.modal', function() {
            if ($('.modal.show').length) {
                $('body').addClass('modal-open');
            }
        });
    </script>

    {{-- <script src="{{ asset('js/includes/toast.js') }}"></script>  --}}
    {{-- bootstrap script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- sidebar script --}}
    <script src="{{ asset('js/admin/sidebar-toggle.js') }}"></script>
    <script src="{{ asset('js/includes/toast.js') }}"></script>
    @yield('scripts')
</body>

</html>
