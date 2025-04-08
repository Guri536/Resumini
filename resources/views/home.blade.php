<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Resumini') }}</title>

    <link rel="icon" href="{{ url('images/ResuminiLogo_1.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css','resources/js/topBarMenu.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- Styles -->
</head>

<body class="parent bg-black/90 max-w-vw
        bg-[url('/public/images/Asset1.svg')] bg-no-repeat bg-center bg-cover bg-fixed
    text-[#1b1b18] items-center lg:justify-center min-h-screen m-0">
    <x-topnavbar></x-topnavbar>

    <div class=" child min-h-full max-h-full justify-center w-full p-2">
        <main class="flex flex-col isolate mx-0 my-5 md:mx-10 lg:mx-60 md:my-10 w-auto rounded-[30px] p-10 bg-black/30 shadow-md shadow-white/20 backdrop-blur-xl text-shadow-[0_35px_35px_rgb(0_0_0_/_0.25)] text-text-primary">
            <div class="text-xl md:text-3xl lg:text-5xl font-[Montserrat]">
                Land Your Dream Job with a Resume That Stands Out.
            </div>
            <span class="h-[2px] bg-white/40 w-3/4 justify-self-center flex m-2"></span>
            <div class="flex flex-col p-5 text-sm md:text-xl lg:text-2xl justify-center">
                Get a professionally designed resume within minutes. Share your experience and skills, to get your career success automated. Stand out to employers. Shine amongst competitors.

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 mb-2">
                    <div class="home_tabs">
                        <div class="text-xl font-bold mb-2">AI-Powered</div>
                        <p class="text-sm md:text-base">Our intelligent Reshumi AI analyzes your experience to highlight your most valuable skills.</p>
                    </div>
                    <div class="home_tabs">
                        <div class="text-xl font-bold mb-2">ATS-Optimized</div>
                        <p class="text-sm md:text-base">Get past automated screening systems with templates designed for maximum visibility.</p>
                    </div>
                    <div class="home_tabs">
                        <div class="text-xl font-bold mb-2">Industry-Specific</div>
                        <p class="text-sm md:text-base">Tailored keywords and formatting for your target industry to increase interview chances.</p>
                    </div>
                </div>

                <div class="text-xl w-full min-h-40 flex flex-wrap md:flex-row md:flex-nowrap m-0 justify-around">
                    <div class="justify-start m-4 w-full sr-only xl:not-sr-only">
                        <ul class="[&>li]:mt-4 list-disc list-inside">
                            <li>ATS Friendly</li>
                            <li>Tailored Formats</li>
                            <li>Industry Specific Keywords</li>
                            <li>Unlimited Edits</li>
                            <li>TeX Document</li>
                        </ul>
                    </div>
                    <div class="flex flex-row m-4 mt-20 md:mt-0 w-1/2 justify-center">
                        <div class="self-end absolute flex flex-wrap md:flex-nowrap w-1/2 justify-around">
                            <form action="{{ route('chat') }}" method="get" class="w-full md:w-1/2 mx-2 justify-center my-2 font-[Montserrat] text-sm md:text-md lg:text-xl">
                                <x-button class=" w-full justify-center
                                hover:bg-green-500/60 
                                hover:-translate-y-1 hover:ring-2 hover:ring-white/50
                                hover:shadow-md hover:shadow-white/50 getBtn
                                " type="submit">
                                    Get Started
                                </x-button>
                            </form>
                            @auth
                            @else
                            <form action="{{ route('login') }}" method="get" class="w-full md:w-1/2 mx-2 justify-center my-2 font-[Montserrat] text-sm md:text-md lg:text-xl">
                                <x-button type="submit" class="w-full justify-center 
                                bg-white/10 border border-white hover:bg-white/20
                                hover:-translate-y-1 hover:ring-2 hover:ring-white/50 
                                hover:shadow-md hover:shadow-white/50">
                                    Sign Up
                                </x-button>
                            </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-xs ms-5 mt-4">For more information, <a href="{{ route('features') }}" class="text-blue-200 hover:underline">click here.</a></div>
    </div>
    <div class="flex isolate mx-3 my-5 md:mx-30 lg:mx-60 md:my-10 w-auto rounded-[30px] p-10 bg-black/30 shadow-md shadow-white/20 backdrop-blur-xl text-shadow-[0_35px_35px_rgb(0_0_0_/_0.25)] text-text-primary">
        <div class="">
            <div class="text-xl font-semibold mb-4">Frequently Asked Questions</div>
            <div class="mb-4">
                <div class="font-medium">How does Reshumi AI work?</div>
                <div class="text-sm text-white/80">Our AI analyzes your experience and the job requirements to create a tailored resume that highlights your most relevant skills and achievements.</div>
            </div>
            <div class="">
                <div class="font-medium">Is my information secure?</div>
                <div class="text-sm text-white/80">Yes, we use enterprise-grade encryption to protect your data. We never share your information with third parties.</div>
            </div>
        </div>
    </div>
    </div>

    <x-footerbar />

</body>

</html>