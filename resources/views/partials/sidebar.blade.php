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
            <div class="h-px bg-black/10"></div>
        </div>

        @php
        $navItem = function ($routeName) {
        return request()->routeIs($routeName)
        ? 'bg-[#6C1517] text-white'
        : 'text-app hover:bg-black/5';
        };
        $onNotificationsPage = request()->routeIs('notifications');
        @endphp

        <nav class="px-4 py-5 space-y-1 flex-1 relative">

            {{-- Home --}}
            <a href="{{ route('feed') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $navItem('feed') }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 10.5 12 3l9 7.5" />
                    <path d="M5 10v10h14V10" />
                </svg>
                <span class="text-[15px] font-semibold">Home</span>
            </a>

            {{-- Search --}}
            <a href="{{ route('search') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $navItem('search') }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="7"></circle>
                    <path d="M21 21l-4.3-4.3"></path>
                </svg>
                <span class="text-[15px] font-semibold">Search</span>
            </a>

            {{-- Notifications (popover first, page on "See all") --}}
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
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8a6 6 0 10-12 0c0 7-3 7-3 7h18s-3 0-3-7"></path>
                        <path d="M13.7 21a2 2 0 01-3.4 0"></path>
                    </svg>
                    <span class="text-[15px] font-semibold">Notifications</span>
                </div>

                <template x-if="unreadCount > 0">
                    <span class="min-w-[22px] h-[22px] px-1.5 rounded-full bg-[#6C1517] text-white text-[12px] font-extrabold flex items-center justify-center">
                        <span x-text="unreadCount"></span>
                    </span>
                </template>
            </a>

            {{-- POPOVER --}}
            <div
                x-show="notifOpen"
                x-transition.origin.top.left
                @click.outside="closeAll()"
                class="absolute left-[calc(100%+16px)] top-[120px] w-[360px] max-w-[360px]
         bg-app-surface text-app rounded-2xl shadow-[0_25px_60px_rgba(0,0,0,.20)]
         border border-app overflow-hidden z-50"
                style="display:none;">
                {{-- header --}}
                <div class="px-4 py-3 flex items-center justify-between bg-app-surface/80 border-b border-app">
                    <div class="text-lg font-extrabold text-app">Notifications</div>

                    {{-- ⋯ menu --}}
                    <div class="relative">
                        <button
                            type="button"
                            class="h-9 w-9 rounded-xl hover:bg-black/5 grid place-items-center text-app"
                            title="More"
                            @click.stop="menuOpen = !menuOpen">
                            ⋯
                        </button>

                        <div
                            x-show="menuOpen"
                            x-transition
                            @click.outside="menuOpen=false"
                            class="absolute right-0 mt-2 w-52 rounded-xl bg-app-surface border border-app
               shadow-[0_16px_40px_rgba(0,0,0,.18)] overflow-hidden"
                            style="display:none;">
                            <button
                                type="button"
                                class="w-full text-left px-4 py-3 text-sm hover:bg-black/5 text-app"
                                @click="markAllRead()">
                                Mark all as read
                            </button>
                        </div>
                    </div>
                </div>

                {{-- tabs + see all --}}
                <div class="px-4 py-3 flex items-center gap-2 border-b border-app bg-app-surface/60">
                    <button
                        type="button"
                        class="px-3 py-1.5 rounded-full text-sm font-semibold"
                        :class="notifTab==='all' ? 'bg-black/5 text-app' : 'hover:bg-black/5 text-app-muted'"
                        @click="notifTab='all'">
                        All
                    </button>

                    <button
                        type="button"
                        class="px-3 py-1.5 rounded-full text-sm font-semibold"
                        :class="notifTab==='unread' ? 'bg-black/5 text-app' : 'hover:bg-black/5 text-app-muted'"
                        @click="notifTab='unread'">
                        Unread
                    </button>

                    <div class="ml-auto">
                        <a
                            href="{{ route('notifications') }}"
                            class="text-sm text-app-muted hover:text-app underline-offset-4 hover:underline">
                            See all
                        </a>
                    </div>
                </div>

                {{-- list --}}
                <div class="max-h-[540px] overflow-y-auto">
                    <template x-for="n in filtered()" :key="n.id">
                        <div class="px-4 py-3 flex gap-3 hover:bg-black/5 border-t border-app">
                            <div class="relative shrink-0">
                                <img :src="n.avatar" class="h-12 w-12 rounded-full object-cover border border-app" alt="avatar">

                                {{-- small type badge (kept, but now warm accent) --}}
                                <div class="absolute -right-1 -bottom-1 h-5 w-5 rounded-full bg-app-accent grid place-items-center text-[11px] font-extrabold text-white">
                                    <span x-text="n.type === 'like' ? '❤' : (n.type === 'invite' ? '⇄' : '!')"></span>
                                </div>
                            </div>

                            <div class="flex-1 leading-tight">
                                <div class="text-sm">
                                    <span class="font-extrabold text-app" x-text="n.name"></span>
                                    <span class="text-app-muted" x-text="' ' + n.text"></span>
                                </div>
                                <div class="text-xs text-app-muted mt-1" x-text="n.time"></div>

                                <div class="mt-2 flex gap-2" x-show="n.type === 'invite'">
                                    <button type="button" class="px-4 py-2 rounded-xl bg-app-brand text-sm font-semibold text-white hover:opacity-95">
                                        Accept
                                    </button>
                                    <button type="button" class="px-4 py-2 rounded-xl bg-black/5 text-sm font-semibold text-app hover:bg-black/10 border border-app">
                                        Decline
                                    </button>
                                </div>
                            </div>

                            <div class="pt-2">
                                <div class="h-2.5 w-2.5 rounded-full bg-app-brand" x-show="n.unread"></div>
                            </div>
                        </div>
                    </template>

                    <div class="px-4 py-4 text-sm text-app-muted" x-show="filtered().length === 0">
                        No notifications here.
                    </div>
                </div>
            </div>

            {{-- Profile --}}
            <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $navItem('profile') }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21a8 8 0 10-16 0"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span class="text-[15px] font-semibold">Profile</span>
            </a>

            {{-- Settings --}}
            <a href="{{ route('settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $navItem('settings') }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
                    <path d="M19.4 15a7.9 7.9 0 0 0 .1-1 7.9 7.9 0 0 0-.1-1l2-1.5-2-3.5-2.3.8a8 8 0 0 0-1.7-1l-.3-2.4H11l-.3 2.4a8 8 0 0 0-1.7 1l-2.3-.8-2 3.5 2 1.5a7.9 7.9 0 0 0-.1 1 7.9 7.9 0 0 0 .1 1l-2 1.5 2 3.5 2.3-.8a8 8 0 0 0 1.7 1l.3 2.4h4l.3-2.4a8 8 0 0 0 1.7-1l2.3.8 2-3.5-2-1.5Z" />
                </svg>
                <span class="text-[15px] font-semibold">Settings</span>
            </a>

        </nav>

        {{-- divider above user --}}
        <div class="px-6">
            <div class="h-px bg-black/10"></div>
        </div>

        @php
        $me = auth()->user();
        @endphp

        <div class="px-6 py-5 flex items-center gap-3">
            <a href="{{ route('profile.show', $me->user_id) }}" class="flex items-center gap-3 flex-1 hover:opacity-90 transition">
                <img src="{{ $me->profile_pic ?? 'https://i.pravatar.cc/120?img=' . $me->user_id }}" class="h-11 w-11 rounded-full object-cover" alt="me">
                <div class="leading-tight">
                    <div class="text-sm font-semibold text-app">{{ $me->first_name }} {{ $me->last_name }}</div>
                    <div class="text-xs text-app-muted">@{{ $me->username }}</div>
                </div>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    title="Logout"
                    class="h-10 w-10 rounded-xl flex items-center justify-center hover:bg-black/5 text-gray-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <path d="M16 17l5-5-5-5" />
                        <path d="M21 12H9" />
                    </svg>
                </button>
            </form>
        </div>

    </div>

    {{-- Alpine component --}}
  <script>
    function notifSidebar() {
      return {
        notifOpen: false,
        notifTab: 'all',
        menuOpen: false,
        unreadCount: 3,
        items: [
          { id: 1, unread: true,  name: 'Cyril Lucero',  text: 'invited you to like LemPang.',                 time: '1d', type: 'invite', avatar: 'https://i.pravatar.cc/120?img=11' },
          { id: 2, unread: true,  name: 'Chyll Mixel Carlos', text: 'invited you to like Cloud Collectibles.',  time: '2d', type: 'invite', avatar: 'https://i.pravatar.cc/120?img=15' },
          { id: 3, unread: true,  name: 'James De Guzman', text: 'invited you to follow Athena East.',          time: '2d', type: 'invite', avatar: 'https://i.pravatar.cc/120?img=28' },
          { id: 4, unread: false, name: 'PUPCOM', text: 'Your birthday is 3 days away. 🎉',                     time: '3d', type: 'info',   avatar: '{{ asset('images/logo.png') }}' },
          { id: 5, unread: false, name: 'Migz Labiano', text: 'reacted to your post.',                          time: '1w', type: 'like',   avatar: 'https://i.pravatar.cc/120?img=49' },
        ],

        toggleNotif() {
          this.notifOpen = !this.notifOpen;
          this.menuOpen = false;
        },

        closeAll() {
          this.notifOpen = false;
          this.menuOpen = false;
        },

        filtered() {
          return this.items.filter(i => this.notifTab === 'all' ? true : i.unread);
        },

        markAllRead() {
          this.items = this.items.map(i => ({ ...i, unread: false }));
          this.unreadCount = 0;
          this.menuOpen = false;
        },
      }
    }
  </script>
</aside>