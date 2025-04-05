<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Resumini</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/topBarMenu.js'])
    @endif
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- RESAI -->
</head>

<body class="parent bg-backTheme text-[#1b1b18] items-center lg:justify-center min-h-screen max-h-screen m-0">
    <x-topnavbar></x-topnavbar>
    <div class="child items-center min-h-[90vh] max-h-[90vh] justify-center w-full p-2 flex flex-col">
        @auth
        <main class="p-5 flex-grow xl:w-3/4 w-full bg-primary overflow-y-auto overscroll-contain rounded-2xl" id="chatBox">
            <x-message-box>Here you go!</x-message-box>
        </main>
        @else
        <main class="p-5 xl:w-3/4 w-full bg-primary rounded-2xl justify-center items-center text-center align-middle flex flex-col flex-grow" id="chatBox">
            <div class="flex flex-col min-w-[40%] bg-ternary rounded-xl outline-2 outline-white outline">
                <label class="justify-center text-center flex flex-row h-auto p-1 text-3xl text-text-primary">
                    Login
                </label>
                <span class="min-h-[2px] max-h-[2px] bg-text-primary w-5/6 self-center text-text-primary">Login to Your Account</span>
                <div class="size-full flex flex-col py-3 xl:px-10 px-2 mt-1">
                    <form action="{{ route('loginFromChat') }}" method="post">
                        @csrf
                        <x-label-input>
                            <x-slot:label>Email:</x-slot>
                                <x-slot:input>
                                    <x-input type='email' class='w-full p-1' id='mail' name='email' required autofocus autocomplete="username" />
                                    </x-slot>
                        </x-label-input>
                        <x-label-input>
                            <x-slot:label>Password:</x-slot>
                                <x-slot:input>
                                    <x-input type='password' class='w-full p-1' id='password' name='password' required autocomplete="current-password"/>
                                    </x-slot>
                        </x-label-input>
                        <div class="flex xl:flex-nowrap flex-wrap w-auto mt-4 xl:mx-7 xl:justify-between justify-center">
                            <a href="{{ route('register') }}" class="inline-flex xl:w-2/5 w-3/4">
                                <x-button class="text-sm w-full justify-center bg-red-400" type="button">Register</x-button>
                            </a>
                            <x-button class="text-sm xl:w-2/5 w-3/4 mt-2 xl:mt-0 justify-center bg-quat" type="submit">Login</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        @endauth
        <div class="flex w-full h-auto justify-center pt-2 rounded-2xl mt-3">
            @auth
            <textarea name="Text" id="qInput" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm disabled:border-gray-200 disabled:bg-gray-400 disabled:text-gray-500 disabled:shadow-none resize-none w-1/2 h-auto" rows='1' placeholder="Ask Reshumi"></textarea>
            @else
            <label class="border-gray-400  border-2 rounded-md shadow-sm bg-gray-200 justify-center text-center w-1/2 h-auto p-2">Please Login.</label>
            @endauth
        </div>
    </div>
    @if (Route::has('login'))
    <div class="h-14.5 hidden lg:block bg-[#00FF00]"></div>
    @endif
</body>

</html>