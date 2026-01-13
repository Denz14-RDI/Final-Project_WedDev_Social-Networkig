@extends('layouts.app')
@section('title','Settings')

@section('content')
@php
  // demo values (replace with Auth::user() later)
  $email = 'juan.delacruz@pup.edu.ph';
  $username = 'juandc';

  $trending = [
    ['tag' => '#PUPEnrollment2025', 'count' => 1234],
    ['tag' => '#IskolarNgBayan',    'count' => 892],
    ['tag' => '#PUPFoundersDay',    'count' => 654],
    ['tag' => '#CCISWeek',          'count' => 432],
    ['tag' => '#PUPBasketball',     'count' => 321],
    ['tag' => '#PUPLibrary',        'count' => 210],
    ['tag' => '#PUPIntrams',        'count' => 198],
    ['tag' => '#PUPScholarship',    'count' => 176],
    ['tag' => '#PUPThesis',         'count' => 165],
    ['tag' => '#PUPEvents',         'count' => 150],
    ['tag' => '#PUPCCIS',           'count' => 132],
    ['tag' => '#PUPEnrollmentHelp', 'count' => 121],
  ];

  $whoToFollow = [
    ['name' => 'PUP Scout', 'handle' => '@pupscout', 'avatar' => 'https://i.pravatar.cc/120?img=3'],
  ];

  // sidebar active styles (copied from Notifications)
  $active = 'bg-[#6C1517] text-white';
  $inactive = 'hover:bg-gray-100 text-gray-800';
@endphp

<div class="min-h-screen bg-[#F2EADA]">
  {{-- 2-COLUMN LAYOUT: LEFT SIDEBAR + (SETTINGS MAIN) --}}
  <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] min-h-screen">

    <!-- LEFT SIDEBAR (copied from Notifications) -->
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

        {{-- user preview pinned at bottom --}}
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

    <!-- SETTINGS MAIN (your original layout kept inside) -->
    <main class="min-h-screen bg-[var(--bg)]">
      <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

          {{-- MAIN --}}
          <div class="lg:col-span-8 space-y-6">
            {{-- Page Header --}}
            <div>
              <h1 class="text-3xl font-extrabold tracking-tight text-neutral-900">Settings</h1>
              <p class="mt-1 text-sm text-neutral-500">Manage your account, notifications, and privacy preferences.</p>
            </div>

            {{-- Account --}}
            <section class="bg-white rounded-2xl shadow-sm ring-1 ring-neutral-200">
              <div class="p-6 border-b border-neutral-200">
                <div class="flex items-start gap-3">
                  <div class="mt-0.5 text-neutral-700">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                      <circle cx="12" cy="7" r="4"/>
                    </svg>
                  </div>
                  <div>
                    <div class="text-lg font-extrabold text-neutral-900">Account</div>
                    <div class="text-sm text-neutral-500">Manage your account settings</div>
                  </div>
                </div>
              </div>

              <div class="p-6 space-y-6">
                {{-- Email + Username --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                  <div>
                    <label class="block text-sm font-semibold text-neutral-800 mb-2">Email</label>
                    <input
                      value="{{ $email }}"
                      disabled
                      class="w-full rounded-xl bg-neutral-50 px-4 py-3 text-sm text-neutral-600 ring-1 ring-neutral-200 outline-none"
                    />
                    <p class="mt-2 text-xs text-neutral-500">Contact support to change your email</p>
                  </div>

                  <div>
                    <label class="block text-sm font-semibold text-neutral-800 mb-2">Username</label>
                    <input
                      value="{{ $username }}"
                      disabled
                      class="w-full rounded-xl bg-neutral-50 px-4 py-3 text-sm text-neutral-600 ring-1 ring-neutral-200 outline-none"
                    />
                  </div>
                </div>

                {{-- Change Password --}}
                <div class="pt-6 border-t border-neutral-200">
                  <div class="text-sm font-semibold text-neutral-900">Change Password</div>
                  <div class="text-xs text-neutral-500 mt-1">Use at least 8 characters for a stronger password.</div>

                  <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input
                      type="password"
                      placeholder="New password"
                      class="w-full rounded-xl bg-white px-4 py-3 text-sm ring-1 ring-neutral-200 outline-none focus:ring-2 focus:ring-[#6C1517]"
                    />
                    <input
                      type="password"
                      placeholder="Confirm new password"
                      class="w-full rounded-xl bg-white px-4 py-3 text-sm ring-1 ring-neutral-200 outline-none focus:ring-2 focus:ring-[#6C1517]"
                    />
                  </div>

                  <div class="mt-4 flex justify-end">
                    <button
                      type="button"
                      class="w-full md:w-auto inline-flex items-center justify-center rounded-xl bg-[#6C1517] px-5 py-3 text-sm font-semibold text-white hover:opacity-95 active:opacity-90"
                    >
                      Update Password
                    </button>
                  </div>
                </div>
              </div>
            </section>

            {{-- Notifications --}}
            <section class="bg-white rounded-2xl shadow-sm ring-1 ring-neutral-200">
              <div class="p-6 border-b border-neutral-200">
                <div class="flex items-start gap-3">
                  <div class="mt-0.5 text-neutral-700">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M18 8a6 6 0 10-12 0c0 7-3 7-3 7h18s-3 0-3-7"/>
                      <path d="M13.7 21a2 2 0 01-3.4 0"/>
                    </svg>
                  </div>
                  <div>
                    <div class="text-lg font-extrabold text-neutral-900">Notifications</div>
                    <div class="text-sm text-neutral-500">Configure how you receive notifications</div>
                  </div>
                </div>
              </div>

              <div class="divide-y divide-neutral-200">
                <div class="p-6 flex items-center justify-between gap-6">
                  <div>
                    <div class="font-semibold text-neutral-900">Email Notifications</div>
                    <div class="text-sm text-neutral-500">Receive notifications via email</div>
                  </div>

                  <label class="relative inline-flex items-center cursor-pointer select-none">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-12 h-7 bg-neutral-200 rounded-full peer-checked:bg-[#6C1517] transition-colors"></div>
                    <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full transition-transform peer-checked:translate-x-5 shadow-sm"></div>
                  </label>
                </div>

                <div class="p-6 flex items-center justify-between gap-6">
                  <div>
                    <div class="font-semibold text-neutral-900">Push Notifications</div>
                    <div class="text-sm text-neutral-500">Receive push notifications</div>
                  </div>

                  <label class="relative inline-flex items-center cursor-pointer select-none">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-12 h-7 bg-neutral-200 rounded-full peer-checked:bg-[#6C1517] transition-colors"></div>
                    <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full transition-transform peer-checked:translate-x-5 shadow-sm"></div>
                  </label>
                </div>
              </div>
            </section>

            {{-- Privacy --}}
            <section class="bg-white rounded-2xl shadow-sm ring-1 ring-neutral-200">
              <div class="p-6 border-b border-neutral-200">
                <div class="flex items-start gap-3">
                  <div class="mt-0.5 text-neutral-700">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/>
                      <circle cx="12" cy="12" r="3"/>
                    </svg>
                  </div>
                  <div>
                    <div class="text-lg font-extrabold text-neutral-900">Privacy</div>
                    <div class="text-sm text-neutral-500">Control your privacy settings</div>
                  </div>
                </div>
              </div>

              <div class="p-6 flex items-center justify-between gap-6">
                <div>
                  <div class="font-semibold text-neutral-900">Private Profile</div>
                  <div class="text-sm text-neutral-500">Only followers can see your posts</div>
                </div>

                <label class="relative inline-flex items-center cursor-pointer select-none">
                  <input type="checkbox" class="sr-only peer">
                  <div class="w-12 h-7 bg-neutral-200 rounded-full peer-checked:bg-[#6C1517] transition-colors"></div>
                  <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full transition-transform peer-checked:translate-x-5 shadow-sm"></div>
                </label>
              </div>
            </section>

            {{-- Danger Zone --}}
            <section class="bg-white rounded-2xl shadow-sm ring-1 ring-red-300">
              <div class="p-6 border-b border-red-200">
                <div class="flex items-start gap-3">
                  <div class="mt-0.5 text-red-600">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                  </div>
                  <div>
                    <div class="text-lg font-extrabold text-red-600">Danger Zone</div>
                    <div class="text-sm text-neutral-500">Irreversible actions</div>
                  </div>
                </div>
              </div>

              <div class="p-6 space-y-5">
                <div class="flex items-center justify-between gap-6">
                  <div>
                    <div class="font-semibold text-neutral-900">Log Out</div>
                    <div class="text-sm text-neutral-500">Sign out of your account</div>
                  </div>

                  <button type="button" class="w-full md:w-auto rounded-xl border border-neutral-200 px-5 py-2 font-semibold hover:bg-neutral-50">
                    Log Out
                  </button>
                </div>

                <div class="pt-5 border-t border-neutral-200 flex items-center justify-between gap-6">
                  <div>
                    <div class="font-semibold text-red-600">Delete Account</div>
                    <div class="text-sm text-neutral-500">Permanently delete your account and data</div>
                  </div>

                  <button type="button" class="w-full md:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-2 font-semibold text-white hover:bg-red-700">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M3 6h18"/>
                      <path d="M8 6V4h8v2"/>
                      <path d="M19 6l-1 14H6L5 6"/>
                      <path d="M10 11v6"/>
                      <path d="M14 11v6"/>
                    </svg>
                    Delete
                  </button>
                </div>
              </div>
            </section>
          </div>

          {{-- RIGHT SIDEBAR (your original) --}}
          <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-6 h-fit">
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-neutral-200">
              <div class="p-5 border-b border-neutral-200">
                <div class="flex items-center gap-2 font-extrabold text-neutral-900">
                  <span aria-hidden="true">📈</span>
                  <span>Trending in PUP</span>
                </div>
              </div>

              <div class="p-5 space-y-4 max-h-[calc(100vh-220px)] overflow-y-auto pr-2 [scrollbar-gutter:stable]">
                @foreach($trending as $i => $t)
                  <div class="rounded-xl hover:bg-neutral-50 p-3 -m-3 transition-colors">
                    <div class="text-xs text-neutral-500">{{ $i + 1 }} · Trending</div>
                    <div class="font-semibold text-neutral-900">{{ $t['tag'] }}</div>
                    <div class="text-sm text-neutral-500">{{ number_format($t['count']) }} posts</div>
                  </div>
                @endforeach
              </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-neutral-200">
              <div class="p-5 border-b border-neutral-200">
                <div class="font-extrabold text-neutral-900 text-lg">Who to Follow</div>
              </div>

              <div class="p-5 space-y-4">
                @foreach($whoToFollow as $p)
                  <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3 min-w-0">
                      <img class="h-10 w-10 rounded-full object-cover" src="{{ $p['avatar'] }}" alt="avatar">
                      <div class="leading-tight min-w-0">
                        <div class="font-semibold text-neutral-900 truncate">{{ $p['name'] }}</div>
                        <div class="text-sm text-neutral-500 truncate">{{ $p['handle'] }}</div>
                      </div>
                    </div>

                    <button class="shrink-0 rounded-xl border border-neutral-200 px-4 py-2 text-sm font-semibold hover:bg-neutral-50">
                      Follow
                    </button>
                  </div>
                @endforeach
              </div>
            </div>
          </aside>

        </div>
      </div>
    </main>

  </div>
</div>
@endsection
