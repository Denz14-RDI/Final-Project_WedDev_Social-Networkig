{{-- resources/views/partials/sidebar.blade.php --}}
<aside
    class="bg-app-sidebar lg:sticky lg:top-0 lg:h-screen border-r border-app"
    x-data="notifSidebar()"
    @keydown.escape.window="closeAll()">

    <div class="h-full flex flex-col">

        {{-- HEADER --}}
        <div class="px-6 pt-6 pb-4">
            <div class="flex items-center gap-3">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="PUPCOM Logo"
                    class="h-11 w-11 rounded-2xl object-contain select-none" />
                <div class="text-lg font-extrabold tracking-wide text-app">PUPCOM</div>
            </div>
        </div>

        {{-- divider --}}
        <div class="px-6">
            <div class="h-px bg-app-divider"></div>
        </div>

        @php
        $navItem = function ($routeName) {
        return request()->routeIs($routeName)
        ? 'bg-app-brand text-white'
        : 'text-app hover-app';
        };
        $onNotificationsPage = request()->routeIs('notifications');
        @endphp

        <nav class="px-4 py-5 space-y-1 flex-1 relative">

            {{-- Home --}}
            <a href="{{ route('feed') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $navItem('feed') }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 10.5 12 3l9 7.5" />
                    <path d="M5 10v10h14V10" />
                </svg>
                <span class="text-[15px] font-semibold">Home</span>
            </a>

            {{-- Search --}}
            <a href="{{ route('search') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $navItem('search') }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="7"></circle>
                    <path d="M21 21l-4.3-4.3"></path>
                </svg>
                <span class="text-[15px] font-semibold">Search</span>
            </a>

            {{-- Notifications --}}
            <a
                href="{{ route('notifications') }}"
                class="flex items-center justify-between gap-3 px-4 py-3 rounded-xl {{ $navItem('notifications') }}"
                @click.prevent="
                    @if(!$onNotificationsPage)
                        toggleNotif()
                    @else
                        window.location.href='{{ route('notifications') }}'
                    @endif
                ">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8a6 6 0 10-12 0c0 7-3 7-3 7h18s-3 0-3-7"></path>
                        <path d="M13.7 21a2 2 0 01-3.4 0"></path>
                    </svg>
                    <span class="text-[15px] font-semibold">Notifications</span>
                </div>

                <template x-if="unreadCount > 0">
                    <span class="min-w-[22px] h-[22px] px-1.5 rounded-full bg-app-brand text-white text-[12px] font-extrabold flex items-center justify-center">
                        <span x-text="unreadCount"></span>
                    </span>
                </template>
            </a>

            {{-- Profile (✅ updated to use shortcut route) --}}
            <a href="{{ route('profile') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $navItem('profile') }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21a8 8 0 10-16 0"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span class="text-[15px] font-semibold">Profile</span>
            </a>

            {{-- Settings --}}
            <a href="{{ route('settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $navItem('settings') }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                    <path d="M19.4 15a7.9 7.9 0 0 0 .1-1 7.9 7.9 0 0 0-.1-1l2-1.5-2-3.5-2.3.8a8 8 0 0 0-1.7-1l-.3-2.4H11l-.3 2.4a8 8 0 0 0-1.7 1l-2.3-.8-2 3.5 2 1.5a7.9 7.9 0 0 0-.1 1 7.9 7.9 0 0 0 .1 1l-2 1.5 2 3.5 2.3-.8a8 8 0 0 0 1.7 1l.3 2.4h4l.3-2.4a8 8 0 0 0 1.7-1l2.3.8 2-3.5-2-1.5Z" />
                </svg>
                <span class="text-[15px] font-semibold">Settings</span>
            </a>
        </nav>

        {{-- divider above user --}}
        <div class="px-6">
            <div class="h-px bg-app-divider"></div>
        </div>

        {{-- User info + logout --}}
        <div class="px-6 py-5 flex items-center gap-3">
            <a href="{{ route('profile') }}" class="flex items-center gap-3 flex-1 hover:opacity-90 transition">
                <img src="{{ asset(Auth::user()->profile_pic ?? 'images/default.png') }}"
                    class="h-11 w-11 rounded-full object-cover" alt="me">
                <div class="leading-tight">
                    <div class="text-sm font-semibold text-app">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                    <div class="text-xs text-app-muted">{{ '@' . Auth::user()->username }}</div>
                </div>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    title="Logout"
                    class="h-10 w-10 rounded-xl flex items-center justify-center hover-app text-app-muted transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <path d="M16 17l5-5-5-5" />
                        <path d="M21 12H9" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>