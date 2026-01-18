<aside class="bg-white border-r border-black/10 lg:sticky lg:top-0 lg:h-screen">
    <div class="h-full flex flex-col">

        {{-- BRAND --}}
        <div class="px-6 pt-6 pb-5">
            <div class="flex items-center gap-3">
                {{-- ✅ Logo added (same as user) --}}
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="PUPCOM Logo"
                    class="h-11 w-11 rounded-2xl object-contain select-none" />

                <div class="leading-tight">
                    <div class="text-lg font-extrabold tracking-wide text-[#6C1517]">PUPCOM</div>
                    <div class="text-xs font-semibold text-gray-500 -mt-0.5">Admin Panel</div>
                </div>
            </div>
        </div>

        <div class="px-6">
            <div class="h-px bg-black/10"></div>
        </div>

        @php
        $navItem = function ($route) {
        return request()->routeIs($route)
        ? 'bg-[#6C1517] text-white shadow-sm'
        : 'text-gray-700 hover:bg-black/5';
        };
        @endphp

        {{-- NAV --}}
        <nav class="px-4 py-5 space-y-1 flex-1">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $navItem('admin.dashboard') }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="2" />
                    <rect x="14" y="3" width="7" height="7" rx="2" />
                    <rect x="14" y="14" width="7" height="7" rx="2" />
                    <rect x="3" y="14" width="7" height="7" rx="2" />
                </svg>
                <span class="text-[15px] font-semibold">Dashboard</span>
            </a>

            <a href="{{ route('admin.moderation') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $navItem('admin.moderation') }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 5h14v14H5z" />
                    <path d="M9 9h6M9 12h6M9 15h6" />
                </svg>
                <span class="text-[15px] font-semibold">Content Moderation</span>
            </a>

            <a href="{{ route('admin.users') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $navItem('admin.users') }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                <span class="text-[15px] font-semibold">User Management</span>
            </a>

            <a href="{{ route('admin.posts') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $navItem('admin.posts') }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <path d="M14 2v6h6" />
                </svg>
                <span class="text-[15px] font-semibold">All Posts</span>
            </a>

            <a href="{{ route('admin.banned') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $navItem('admin.banned') }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M7 7l10 10" />
                </svg>
                <span class="text-[15px] font-semibold">Banned Users</span>
            </a>

            <a href="{{ route('admin.settings') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $navItem('admin.settings') }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                    <path d="M19.4 15a7.9 7.9 0 0 0 .1-1 7.9 7.9 0 0 0-.1-1l2-1.5-2-3.5-2.3.8a8 8 0 0 0-1.7-1l-.3-2.4H11l-.3 2.4a8 8 0 0 0-1.7 1l-2.3-.8-2 3.5 2 1.5a7.9 7.9 0 0 0-.1 1 7.9 7.9 0 0 0 .1 1l-2 1.5 2 3.5 2.3-.8a8 8 0 0 0 1.7 1l.3 2.4h4l.3-2.4a8 8 0 0 0 1.7-1l2.3.8 2-3.5-2-1.5Z" />
                </svg>
                <span class="text-[15px] font-semibold">Settings</span>
            </a>
        </nav>

        <div class="px-6">
            <div class="h-px bg-black/10"></div>
        </div>

        {{-- ADMIN PROFILE / LOGOUT --}}
        @php
        $admin = auth()->user();
        $adminName = $admin->name ?? 'PUPCOM Admin';
        $adminRole = 'Administrator';
        $initial = strtoupper(mb_substr($adminName, 0, 1));
        @endphp

        <div class="px-6 py-5 flex items-center gap-3">
            <div class="h-11 w-11 rounded-full bg-[#F2F2F2] border border-black/10 flex items-center justify-center font-bold text-[#6C1517]">
                {{ $initial }}
            </div>

            <div class="leading-tight flex-1">
                <div class="text-sm font-semibold text-gray-900">{{ $adminName }}</div>
                <div class="text-xs text-gray-500">{{ $adminRole }}</div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Logout"
                    class="h-10 w-10 rounded-xl flex items-center justify-center hover:bg-black/5 text-gray-600 transition">
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