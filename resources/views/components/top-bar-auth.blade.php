@if (Route::has('login'))
<nav class="flex justify-left items-left gap-4">
    @auth
    <div class="relative inline-block text-left">
        <!-- <div> -->
            <button type="button" class="inline-flex justify-center w-full rounded-md border border-brd-primary shadow-sm px-4 py-2 text-sm font-medium text-text-primary hover:border-hvr-brd-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="menu-button" aria-expanded="true" aria-haspopup="true">
                {{ Auth::user()->name }}
                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        <!-- </div> -->

        <div class="absolute hidden mt-2 w-auto rounded-md shadow-lg bg-white focus:outline" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" id="menu-items">
            <div class="py-1" role="none">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-0">Account settings</a>
                <form method="POST" action="{{ Route('logout') }}" role="none">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-3">Sign out</button>
                </form>
            </div>
        </div>
    </div>
    
    @else
    <a
        href="{{ route('login') }}"
        class="inline-block px-5 py-1.5 text-text-primary border border-brd-primary hover:border-hvr-brd-primary rounded-sm text-sm leading-normal">
        Log in
    </a>

    @if (Route::has('register'))
    <a
        href="{{ route('register') }}"
        class="inline-block px-5 py-1.5 border-brd-primary hover:border-hvr-brd-primary border text-text-primary rounded-sm text-sm leading-normal">
        Register
    </a>
    @endif
    @endauth
</nav>
@endif