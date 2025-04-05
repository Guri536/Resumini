<header class="flex py-2 px-5 justify-center w-full lg:max-w-full text-sm mb-3 not-has-[nav]:hidden bg-ternary rounded-b-xl">
        <div class="justtify-start flex w-full h-full">
            <!-- <img src="{{ asset('images\ResuminiLogo_1.svg') }}" alt="" class="w-auto h-8 mx-4"> -->
            <x-logolabel></x-logolabel>
            <nav class="text-primary text-lg flex flex-col align-middle justify-center ms-12 sr-only md:not-sr-only">
                <ul class="flex flex-row [&>li]:ms-5">
                    <li>
                        <a href="#" target="_blank" rel="noopener noreferrer" class="hover:underline">Features</a>
                    </li>
                    <li>
                        <a href="#" target="_blank" rel="noopener noreferrer" class="hover:underline">How it works?</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="justify-center flex w-1/2">
        </div>
        <div class="flex justify-end w-full">
            <x-top-bar-auth />
        </div>
</header>