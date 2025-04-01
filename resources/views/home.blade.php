<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Resumini') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css'])
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- Styles -->
</head>

<body class="parent bg-backTheme text-[#1b1b18] items-center lg:justify-center min-h-screen max-h-screen m-0">
    <header class="flex py-2 px-5 justify-center w-full lg:max-w-full text-sm mb-3 not-has-[nav]:hidden bg-ternary rounded-b-xl">
        <div class="justtify-start flex w-full h-full">
            <img src="{{ asset('images\ResuminiLogo.svg') }}" alt="" class="w-auto h-8 mx-4">
        </div>
        <div class="justify-center flex w-full">

        </div>
        <div class="flex justify-end w-full">
            <x-top-bar-auth />
        </div>
    </header>
    <div class="child min-h-full max-h-full justify-center w-full p-2 flex">
        
    </div>
</body>

</html>