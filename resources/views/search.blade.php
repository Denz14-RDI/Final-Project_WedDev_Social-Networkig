@extends('layouts.app')
@section('title','Search')

@section('content')
@php
  $q = request('q', '');

  // demo data (replace with DB later)
  $trending = [
    ['tag' => '#PUPEnrollment2025', 'count' => 1234],
    ['tag' => '#IskolarNgBayan',    'count' => 892],
    ['tag' => '#PUPFoundersDay',    'count' => 654],
    ['tag' => '#CCISWeek',          'count' => 432],
    ['tag' => '#PUPBasketball',     'count' => 321],
    ['tag' => '#BSIT',              'count' => 298],
    ['tag' => '#StudentLife',       'count' => 267],
    ['tag' => '#LostAndFound',      'count' => 189],
  ];

  $people = [
    [
      'name' => 'Juan Dela Cruz',
      'handle' => '@juandc',
      'meta' => 'BSIT Student | Web Developer | Coffee Enthusiast',
      'avatar' => 'https://i.pravatar.cc/120?img=12',
      'badge' => null,
    ],
    [
      'name' => 'PUP Central Student Organization',
      'handle' => '@pupcso',
      'meta' => 'Official student organization of PUP',
      'avatar' => 'https://i.pravatar.cc/120?img=32',
      'badge' => 'Organization',
    ],
    [
      'name' => 'Prof. Maria Santos',
      'handle' => '@mariasantos',
      'meta' => 'Associate Professor | CCIS',
      'avatar' => 'https://i.pravatar.cc/120?img=49',
      'badge' => 'Faculty',
    ],
    [
      'name' => 'PUP Tech Club',
      'handle' => '@puptechclub',
      'meta' => 'Technology and Innovation Club',
      'avatar' => 'https://i.pravatar.cc/120?img=15',
      'badge' => 'Organization',
    ],
    [
      'name' => 'PUP Alumni Association',
      'handle' => '@pupalumni',
      'meta' => 'Connecting PUP graduates',
      'avatar' => 'https://i.pravatar.cc/120?img=8',
      'badge' => 'Alumni',
    ],
  ];

  $whoToFollow = [
    ['name' => 'PUP Scout', 'handle' => '@pupscout', 'avatar' => 'https://i.pravatar.cc/120?img=3'],
  ];

  // sidebar active styles (copied from Notifications)
  $active = 'bg-[#6C1517] text-white';
  $inactive = 'hover:bg-gray-100 text-gray-800';
@endphp

<div class="min-h-screen bg-[#F2EADA]">
  {{-- 2-COLUMN LAYOUT: LEFT SIDEBAR + (SEARCH CENTER+RIGHT) --}}
  <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] min-h-screen">

    <!-- LEFT SIDEBAR (copied from Notifications) -->
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

          <a href="{{ route('friends') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-normal
            {{ request()->routeIs('friends') ? $active : $inactive }}">
            <span class="text-lg">👥</span>
            Friends
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

    <!-- SEARCH MAIN (your original center+right content) -->
    <main class="min-h-screen bg-[var(--bg)]">
      <div class="mx-auto max-w-[1400px] px-4 py-6">
        <div class="grid grid-cols-12 gap-6">

          {{-- CENTER --}}
          <div class="col-span-12 lg:col-span-8 space-y-5">

            {{-- TOP SEARCH BOX ONLY --}}
            <form action="{{ route('search') }}" method="GET"
                  class="bg-white rounded-2xl shadow-sm ring-1 ring-neutral-200 p-4">
              <div class="flex items-center gap-3">
                <span class="text-neutral-400">🔍</span>
                <input
                  type="text"
                  name="q"
                  value="{{ $q }}"
                  placeholder="Search PUPCOM..."
                  class="w-full bg-transparent outline-none text-sm placeholder:text-neutral-400"
                />
              </div>
            </form>

            {{-- RESULTS (People to Follow only) --}}
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-neutral-200 p-5">
              <div class="text-lg font-extrabold flex items-center gap-2">
                <span>👥</span>
                <span>People to Follow</span>
              </div>

              <div class="mt-4 space-y-4">
                @foreach($people as $p)
                  <div class="flex items-center justify-between rounded-2xl border border-neutral-200 bg-white p-4">
                    <div class="flex items-center gap-4">
                      <img class="h-12 w-12 rounded-full object-cover" src="{{ $p['avatar'] }}" alt="avatar">
                      <div class="leading-tight">
                        <div class="flex items-center gap-2">
                          <div class="font-extrabold">{{ $p['name'] }}</div>
                          @if(!empty($p['badge']))
                            <span class="rounded-full bg-neutral-100 px-2.5 py-1 text-xs font-semibold text-neutral-700">
                              {{ $p['badge'] }}
                            </span>
                          @endif
                        </div>
                        <div class="text-sm text-neutral-500">{{ $p['handle'] }}</div>
                        <div class="text-sm text-neutral-600 mt-1">{{ $p['meta'] }}</div>
                      </div>
                    </div>

                    <button class="rounded-xl border border-neutral-200 px-4 py-2 font-semibold hover:bg-neutral-50">
                      Follow
                    </button>
                  </div>
                @endforeach
              </div>
            </div>

          </div>

          {{-- RIGHT --}}
          <div class="col-span-12 lg:col-span-4 space-y-6">

            {{-- Trending in PUP --}}
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-neutral-200 p-5">
              <div class="flex items-center gap-2 font-bold">
                <span>📈</span>
                <span>Trending in PUP</span>
              </div>

              <div class="mt-4 space-y-4">
                @foreach(array_slice($trending, 0, 5) as $i => $t)
                  <div>
                    <div class="text-xs text-neutral-500">{{ $i + 1 }} · Trending</div>
                    <div class="font-semibold">{{ $t['tag'] }}</div>
                    <div class="text-sm text-neutral-500">{{ number_format($t['count']) }} posts</div>
                  </div>
                @endforeach
              </div>
            </div>

            {{-- Who to Follow --}}
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-neutral-200 p-5">
              <div class="font-bold text-lg">Who to Follow</div>

              <div class="mt-4 space-y-4">
                @foreach($whoToFollow as $p)
                  <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                      <img class="h-10 w-10 rounded-full object-cover" src="{{ $p['avatar'] }}" alt="avatar">
                      <div class="leading-tight">
                        <div class="font-semibold">{{ $p['name'] }}</div>
                        <div class="text-sm text-neutral-500">{{ $p['handle'] }}</div>
                      </div>
                    </div>

                    <button class="rounded-xl border border-neutral-200 px-4 py-2 font-semibold hover:bg-neutral-50">
                      Follow
                    </button>
                  </div>
                @endforeach
              </div>
            </div>

          </div>

        </div>
      </div>
    </main>

  </div>
</div>
@endsection
