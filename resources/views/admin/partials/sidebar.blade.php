<aside class="bg-app-sidebar border-r border-app lg:sticky lg:top-0 lg:h-screen">
    <div class="h-full flex flex-col">

        {{-- BRAND --}}
        <div class="px-6 pt-6 pb-5">
            <div class="flex items-center gap-3">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="PUPCOM Logo"
                    class="h-11 w-11 rounded-2xl object-contain select-none" />

                <div class="leading-tight">
                    <div class="text-lg font-extrabold tracking-wide text-app">PUPCOM</div>
                    <div class="text-xs font-semibold text-app-muted -mt-0.5">Admin Panel</div>
                </div>
            </div>
        </div>

        <div class="px-6">
            <div class="h-px bg-app-divider"></div>
        </div>

        @php
        $navItem = fn($route) => request()->routeIs($route)
        ? 'bg-app-brand text-white shadow-sm'
        : 'text-app hover-app';
        @endphp

        {{-- NAV --}}
        <nav class="px-4 py-5 space-y-1 flex-1">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $navItem('admin.dashboard') }}">
                <span class="text-xl">📊</span>
                <span class="text-[15px] font-semibold">Dashboard</span>
            </a>

            <a href="{{ route('admin.reports.moderation') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $navItem('admin.reports.moderation') }}">
                <span class="text-xl">🛡️</span>
                <span class="text-[15px] font-semibold">Content Moderation</span>
            </a>

            <a href="{{ route('admin.settings') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ $navItem('admin.settings') }}">
                <span class="text-xl">⚙️</span>
                <span class="text-[15px] font-semibold">Settings</span>
            </a>
        </nav>

        <div class="px-6">
            <div class="h-px bg-app-divider"></div>
        </div>

        {{-- ADMIN PROFILE / LOGOUT --}}
        @php
        $admin = auth()->user();
        $adminName = trim(($admin->first_name ?? '') . ' ' . ($admin->last_name ?? ''));
        $adminUsername = '@' . ($admin->username ?? 'admin');
        $adminRole = 'Administrator';
        $adminPic = !empty($admin->profile_pic) ? $admin->profile_pic : 'images/default.png';
        @endphp

        <div class="px-6 py-5 flex items-center gap-3">
            <img src="{{ asset($adminPic) }}"
                alt="Admin Avatar"
                class="h-11 w-11 rounded-full object-cover border border-app" />

            <div class="leading-tight flex-1 min-w-0">
                <div class="text-sm font-semibold text-app truncate">{{ $adminName ?: 'Admin User' }}</div>
                <div class="text-xs text-app-muted truncate">{{ $adminUsername }}</div>
                <div class="text-xs text-app-mutedlight">{{ $adminRole }}</div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Logout"
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