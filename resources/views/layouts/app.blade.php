<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Sweetalert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>


    @stack('css')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">

        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <div class="content-body px-4 py-6 max-w-7xl mx-auto">
            @yield('content')
        </div>
    </div>

    <!-- Global JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Global Sweetalert Helpers
        function showSuccessToast(message) {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: message,
                showConfirmButton: false,
                timer: 2000
            });
        }

        function showErrorToast(message) {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "error",
                title: message,
                showConfirmButton: false,
                timer: 2500
            });
        }

        function showSwal(options, callback = null) {
            Swal.fire(options).then((result) => {
                if (result.isConfirmed && callback) callback();
            });
        }
    </script>

    <!-- CRUD Ajax (delete / mass delete) -->
    @include('layouts.crud_ajax')

    <!-- Select2 + Category → Subcategory AJAX -->
    @include('layouts.select2_ajax')

    @yield('scripts')
    @stack('js')
</body>
</html>
