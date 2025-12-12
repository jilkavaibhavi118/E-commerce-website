<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'My Store') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body class="bg-gray-100 text-gray-900">

    {{-- ================= HEADER ================= --}}
    @include('frontend.layouts.header')

    {{-- ================= MAIN CONTENT ================= --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- ================= FOOTER ================= --}}
    @include('frontend.layouts.footer')

    @include('frontend.layouts.ajax_sacript')


</body>
</html>
