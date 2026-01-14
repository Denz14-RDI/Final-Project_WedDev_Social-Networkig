<aside class="bg-white border-r border-gray-200 lg:sticky lg:top-0 lg:h-screen">
    <div class="h-full flex flex-col">

        {{-- header --}}
        <div class="px-6 py-6 border-b border-gray-200 flex items-center gap-4">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="PUPCOM Logo"
                class="h-14 w-14 rounded-2xl object-contain select-none" />

            <div class="leading-tight">
                <div class="text-xl font-extrabold text-gray-900 tracking-wide">PUPCOM</div>
            </div>
        </div>

        {{-- nav --}}
        <nav class="px-4 py-4 space-y-1 flex-1">
            @php
            $navItem = function ($routeName) {
            return request()->routeIs($routeName)
            ? 'bg-[#6C1517] text-white'
            : 'hover:bg-gray-100 text-gray-800';
            };
            @endphp

            <a href="{{ route('feed') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $navItem('feed') }}">
                <span class="text-lg">⌂</span>
                Home
            </a>

            <a href="{{ route('search') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $navItem('search') }}">
                <span class="text-lg">⌕</span>
                Search
            </a>

            <a href="{{ route('notifications') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $navItem('notifications') }}">
                <span class="text-lg">🔔</span>
                Notifications
            </a>

            <a href="{{ route('profile') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $navItem('profile') }}">
                <span class="text-lg">👤</span>
                Profile
            </a>

            <a href="{{ route('settings') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $navItem('settings') }}">
                <span class="text-lg">⚙</span>
                Settings
            </a>
        </nav>

        {{-- bottom user preview + logout icon --}}
        <div class="border-t border-gray-200">
            <div class="px-6 py-5 flex items-center gap-3">
                <a href="{{ route('profile') }}" class="flex items-center gap-3 flex-1 hover:opacity-90 transition">
                    <div class="h-11 w-11 rounded-full bg-gray-200"></div>
                    <div class="leading-tight">
                        <div class="text-sm font-semibold text-gray-900">Juan Dela Cruz</div>
                        <div class="text-xs text-gray-500">@juanisko</div>
                    </div>
                </a>

                {{-- Logout (icon not “childish”: simple box-arrow-right SVG) --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        title="Logout"
                        class="h-10 w-10 rounded-xl flex items-center justify-center hover:bg-gray-100 text-gray-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <path d="M16 17l5-5-5-5" />
                            <path d="M21 12H9" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </div>
</aside>