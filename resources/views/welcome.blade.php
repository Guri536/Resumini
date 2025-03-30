<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- RESAI -->
</head>

<body class="parent bg-backTheme text-[#1b1b18] p-2 lg:p-2 items-center lg:justify-center min-h-screen max-h-screen">
    <header class="flex p-2 justify-end w-full lg:max-w-full max-w-[335px] text-sm mb-3 not-has-[nav]:hidden">
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
    <div class="child items-center min-h-[90vh] max-h-[90vh] justify-center w-full p-2 flex flex-col">
        @auth
        <main class="p-5 flex-grow w-3/4 bg-primary overflow-y-auto overscroll-contain rounded-2xl" id="chatBox">
        </main>
        @else
        <main class="p-5 w-3/4 bg-primary rounded-2xl justify-center items-center text-center align-middle flex flex-col flex-grow" id="chatBox">
            <div class="flex flex-col min-h-80 min-w-[40%] bg-ternary rounded-xl outline-2 outline-white outline">
                <label class="justify-center text-center flex flex-row h-auto p-2 text-3xl">
                    Login
                </label>

            </div>
        </main>
        @endauth
        <div class="flex w-full h-auto justify-center pt-2 rounded-2xl mt-3">
            @auth
            <textarea name="Text" id="qInput" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm disabled:border-gray-200 disabled:bg-gray-400 disabled:text-gray-500 disabled:shadow-none resize-none w-1/2 h-auto" rows='1' placeholder="Ask Reshumi">
            </textarea>
            @else
            <label class="border-gray-400  border-2 rounded-md shadow-sm bg-gray-200 justify-center text-center w-1/2 h-auto p-2">
                You Need To Login/Register In Order To Use The Chat Bot
            </label>
            @endauth
        </div>
    </div>
    @if (Route::has('login'))
    <div class="h-14.5 hidden lg:block bg-[#00FF00]"></div>
    @endif
</body>

</html>