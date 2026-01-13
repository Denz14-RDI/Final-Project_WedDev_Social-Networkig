@extends('layouts.app')
@section('title','Notifications')

@section('content')
<div class="min-h-screen bg-[#F2EADA]">
  {{-- 2-COLUMN LAYOUT: LEFT SIDEBAR + NOTIFICATIONS (CENTER+RIGHT MERGED) --}}
  <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] min-h-screen">

    <!-- LEFT SIDEBAR (FULL HEIGHT like reference) -->
    <aside class="bg-white border-r border-gray-200 lg:sticky lg:top-0 lg:h-screen">
      <div class="h-full flex flex-col">

        {{-- header (bigger logo + bigger PUPCOM) --}}
        <div class="px-6 py-6 border-b border-gray-200 flex items-center gap-4">
          <img
            src="{{ asset('images/logo.png') }}"
            alt="PUPCOM Logo"
            class="h-14 w-14 rounded-2xl object-contain select-none" />

          <div class="leading-tight">
            <div class="text-xl font-extrabold text-gray-900 tracking-wide">PUPCOM</div>
          </div>
        </div>

        @php
        $active = 'bg-[#6C1517] text-white';
        $inactive = 'hover:bg-gray-100 text-gray-800';
        @endphp

        <nav class="px-4 py-4 space-y-1 flex-1">
          <a href="{{ route('feed') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-normal
            {{ request()->routeIs('feed') ? $active : $inactive }}">
            <span class="text-lg">⌂</span>
            Home
          </a>

          <a href="{{ route('search') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-normal
            {{ request()->routeIs('search') ? $active : $inactive }}">
            <span class="text-lg">⌕</span>
            Search
          </a>

          <a href="{{ route('notifications') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-normal
            {{ request()->routeIs('notifications') ? $active : $inactive }}">
            <span class="text-lg">🔔</span>
            Notifications
          </a>

          <a href="{{ route('profile') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-normal
            {{ request()->routeIs('profile') ? $active : $inactive }}">
            <span class="text-lg">👤</span>
            Profile
          </a>

          <a href="{{ route('settings') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-normal
            {{ request()->routeIs('settings') ? $active : $inactive }}">
            <span class="text-lg">⚙</span>
            Settings
          </a>
        </nav>

        {{-- user preview pinned at bottom (CLICKABLE -> profile) --}}
        <a
          href="{{ route('profile') }}"
          class="px-6 py-5 border-t border-gray-200 flex items-center gap-3 hover:bg-gray-50 transition">
          <div class="h-11 w-11 rounded-full bg-gray-200"></div>
          <div class="leading-tight">
            <div class="text-sm font-semibold text-gray-900">Juan Dela Cruz</div>
            <div class="text-xs text-gray-500">@juanisko</div>
          </div>
        </a>

      </div>
    </aside>


    <!-- NOTIFICATIONS (CENTER + RIGHT MERGED) -->
    <main class="min-h-screen bg-[#F6F0EE]">
      {{-- top header bar --}}
      <div class="h-16 border-b border-gray-200 bg-[#F6F0EE] flex items-center px-8">
        <div class="flex items-center gap-3">
          <span class="text-lg">▮▮</span>
          <h1 class="text-xl font-extrabold text-[#6C1517]">Notifications</h1>
        </div>
      </div>

      {{-- content spans the whole main area now --}}
      <div class="px-6 lg:px-14 py-10">
        <div class="max-w-5xl mx-auto">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-3xl font-extrabold text-gray-900">Recent Activity</h2>
            <button class="text-sm font-semibold text-[#6C1517] hover:underline">
              Mark all as read
            </button>
          </div>

          <div class="space-y-6">

            {{-- unread (pink) --}}
            <div class="bg-[#F3E6E7] border border-[#E7CACC] rounded-2xl shadow-[0_12px_26px_rgba(0,0,0,.12)] p-6">
              <div class="flex items-center gap-4">
                <div class="h-14 w-14 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-700">
                  M
                </div>
                <div class="flex-1">
                  <div class="text-sm text-gray-900">
                    <span class="font-semibold">Maria Clara</span> liked your post about the campus library.
                  </div>
                  <div class="text-xs text-gray-500 mt-1">5m ago</div>
                </div>
                <div class="h-2.5 w-2.5 rounded-full bg-[#6C1517]"></div>
              </div>
            </div>

            {{-- unread (pink) --}}
            <div class="bg-[#F3E6E7] border border-[#E7CACC] rounded-2xl shadow-[0_12px_26px_rgba(0,0,0,.12)] p-6">
              <div class="flex items-center gap-4">
                <div class="h-14 w-14 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-700">
                  C
                </div>
                <div class="flex-1">
                  <div class="text-sm text-gray-900">
                    <span class="font-semibold">Crisostomo Ibarra</span> commented: “Great points about the new curriculum!”
                  </div>
                  <div class="text-xs text-gray-500 mt-1">2h ago</div>
                </div>
                <div class="h-2.5 w-2.5 rounded-full bg-[#6C1517]"></div>
              </div>
            </div>

            {{-- read (white) --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-[0_12px_26px_rgba(0,0,0,.10)] p-6">
              <div class="flex items-center gap-4">
                <div class="h-14 w-14 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-700">
                  E
                </div>
                <div class="flex-1">
                  <div class="text-sm text-gray-900">
                    <span class="font-semibold">Elias</span> sent you a friend request.
                  </div>
                  <div class="text-xs text-gray-500 mt-1">5h ago</div>
                </div>
              </div>
            </div>

            {{-- read (white) --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-[0_12px_26px_rgba(0,0,0,.10)] p-6">
              <div class="flex items-center gap-4">
                <div class="h-14 w-14 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
                  🔔
                </div>
                <div class="flex-1">
                  <div class="text-sm text-gray-900">
                    Your post <span class="font-semibold">“Study Group Tomorrow”</span> is trending in Academic!
                  </div>
                  <div class="text-xs text-gray-500 mt-1">1d ago</div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </main>

  </div>
</div>
@endsection