<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="{{ url('images/ResuminiLogo_1.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css','resources/js/topBarMenu.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="parent bg-black/90 max-w-vw text-[#1b1b18] items-center lg:justify-center min-h-screen m-0">
        <x-banner />
            <x-topnavbar/>
            <!-- Page Content -->
            <main class='min-h-screen'>
                {{ $slot }}
            </main>
        <x-footerbar/>
        @stack('modals')

        @livewireScripts
    </body>
</html>
