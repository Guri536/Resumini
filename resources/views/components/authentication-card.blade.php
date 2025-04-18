<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-black/90 text-white">
    <div>
        {{ $logo }}
    </div>

    <div class="w-4/5 sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg text-black">
        {{ $slot }}
    </div>
</div>
