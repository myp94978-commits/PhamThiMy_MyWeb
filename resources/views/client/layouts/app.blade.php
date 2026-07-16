<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MyWeb - E-Commerce')</title>
    
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    {{-- CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @yield('css')
</head>
<body>
    {{-- Navigation --}}
    @include('client.partials.navbar')
    
    {{-- Header --}}
    @include('client.partials.header')
    
    {{-- Main Content --}}
    <main class="main-content">
        @yield('content')
    </main>
    
    {{-- Footer --}}
    @include('client.partials.footer')
    
    {{-- Additional Scripts --}}
    @yield('js')
</body>
</html>
