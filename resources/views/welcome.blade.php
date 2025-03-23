<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-backTheme text-[#1b1b18] p-4 lg:p-6 items-center lg:justify-center min-h-screen">
    <header class="flex justify-end w-full lg:max-w-full max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
        @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            @auth
            <a
                href="{{ url('/dashboard') }}"
                class="inline-block px-5 py-1.5 border-[#b5b5b563] hover:border-[#e4e4e4] border text-[#e4e4e4] rounded-sm text-sm leading-normal">
                Dashboard
            </a>
            @else
            <a
                href="{{ route('login') }}"
                class="inline-block px-5 py-1.5 text-[#e4e4e4] border border-[#b5b5b563] hover:border-[#e4e4e4] rounded-sm text-sm leading-normal">
                Log in
            </a>

            @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="inline-block px-5 py-1.5 border-[#b5b5b563] hover:border-[#e4e4e4] border text-[#e4e4e4] rounded-sm text-sm leading-normal">
                Register
            </a>
            @endif
            @endauth
        </nav>
        @endif
    </header>
    <div class="items-center justify-center w-full min-h-[700px]">
        <main class="p-5 w-full h-[650px] bg-primary overflow-y-auto overscroll-contain rounded-2xl">
            <x-message-box>
                How are you doing
            </x-message-box>
            <x-message-box>
                Yee haw dawgs
            </x-message-box>
            <x-message-box>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea eveniet recusandae repellendus nesciunt placeat, voluptate quas laboriosam incidunt mollitia provident sequi animi reprehenderit, iure nemo minima ipsam soluta fugit aperiam? Tenetur aliquid porro, fuga amet beatae ad excepturi eligendi nisi repudiandae aspernat
            </x-message-box>
            <x-sender-box>
                Hey man
            </x-sender-box>
            <x-sender-box>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia, aperiam quos voluptatum, inventore odit quo fugit, quibusdam ipsa veniam eveniet odio vitae minus! Dolo
            </x-sender-box>
            <x-message-box>
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatem fuga, quisquam dolor accusamus delectus ullam, itaque labore distinctio odit mollitia consectetur sapiente voluptatibus quidem odio. Ut, facilis ipsam cupiditate illum magnam eligendi optio. Repellat pariatur iusto magni est similique excepturi ipsam hic corrupti voluptatibus autem totam ducimus quos, nisi aliquam voluptates earum sed vel provident a dolorum fuga cumque a
            </x-message-box>
        </main>
        <div class="flex w-full h-auto justify-center pt-2 rounded-2xl">
            <x-input class="w-1/2" placeholder="Query Here">
                <i></i>
            </x-input>
        </div>
    </div>

    @if (Route::has('login'))
    <div class="h-14.5 hidden lg:block bg-[#00FF00]"></div>
    @endif
</body>

</html>