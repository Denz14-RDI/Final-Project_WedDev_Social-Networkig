@extends('layouts.app')
@section('title','Profile')

@section('content')
<div class="min-h-screen bg-[#F7F4EF]">
  {{-- FULL WIDTH LAYOUT --}}
  <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] min-h-screen">

    <!-- LEFT SIDEBAR (same one we’ve been using) -->
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
          ? 'bg-[#6C1517] text-white font-semibold'
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

        {{-- bottom user preview (clickable -> profile) --}}
        <a href="{{ route('profile') }}"
          class="px-6 py-5 border-t border-gray-200 flex items-center gap-3 hover:bg-gray-50 transition">
          <div class="h-11 w-11 rounded-full bg-gray-200"></div>
          <div class="leading-tight">
            <div class="text-sm font-semibold text-gray-900">Juan Dela Cruz</div>
            <div class="text-xs text-gray-500">@juanisko</div>
          </div>
        </a>

      </div>
    </aside>

    <!-- PROFILE MAIN (center+right together like notifications) -->
    <main class="bg-[#F7F4EF]">
      <div class="px-6 py-10">
        <div class="max-w-[980px] mx-auto">

          {{-- profile header card --}}
          <div class="bg-white rounded-2xl shadow-[0_18px_40px_rgba(0,0,0,.12)] border border-black/10 overflow-hidden">

            {{-- COVER (gradient like reference) --}}
            <div class="h-44 sm:h-52 bg-gradient-to-r from-[#6C1517] via-[#7B2A2D] to-[#9B5658]"></div>

            {{-- CONTENT --}}
            <div class="px-8 pb-8">
              {{-- Header block uses padding-top to push content BELOW the cover like the reference --}}
              <div class="relative pt-8 sm:pt-10">
                {{-- avatar --}}
                <div class="absolute -top-10 sm:-top-12 left-0">
                  <div class="h-24 w-24 sm:h-28 sm:w-28 rounded-full bg-gray-200 ring-4 ring-white"></div>
                </div>

                {{-- edit button --}}
                <div class="absolute top-3 right-0">
                  <a href="#"
                    class="inline-flex items-center justify-center rounded-xl bg-[#6C1517] px-5 py-2.5 text-sm font-semibold text-white hover:opacity-95">
                    Edit Profile
                  </a>
                </div>

                {{-- text (closer to avatar) --}}
                <div class="mt-10 sm:mt-12">
                  <div class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight">
                    Juan Dela Cruz
                  </div>
                  <div class="mt-1 text-sm text-gray-500">@juan_delacruz</div>

                  <div class="mt-3 text-sm text-gray-700">
                    Hello! I’m part of the PUP community.
                  </div>

                  <div class="mt-3 flex items-center gap-2 text-sm text-gray-600">
                    <span>📅</span>
                    <span>Joined January 2024</span>
                  </div>

                  <div class="mt-4 text-sm text-gray-800">
                    <span class="font-extrabold">2</span>
                    <span class="ml-1">Iskoolmates</span>
                  </div>
                </div>
              </div>



              <div class="mt-8 border-t border-black/10"></div>

              {{-- posts list (sample) --}}
              <div class="mt-6 space-y-6">

                {{-- post 1 --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_10px_18px_rgba(0,0,0,.08)] p-6">
                  <div class="flex items-start gap-4">
                    <div class="h-12 w-12 rounded-full bg-gray-200"></div>

                    <div class="flex-1">
                      <div class="flex items-start justify-between gap-4">
                        <div class="leading-tight">
                          <div class="font-extrabold text-gray-900">Juan Dela Cruz</div>
                          <div class="text-sm text-gray-500">@juan_delacruz · 1d ago</div>
                        </div>
                        <button class="text-gray-400 hover:text-gray-600">⋯</button>
                      </div>

                      <div class="mt-3 text-sm text-gray-900">
                        🔴 <span class="font-extrabold">LOST ITEM ALERT</span> 🔴<br><br>
                        I lost my black JBL earphones somewhere in the CCIS building (3rd floor) yesterday around 4PM.
                        If you found it, please message me. Thank you!
                      </div>

                      <div class="mt-4 h-48 rounded-2xl bg-gray-200"></div>
                    </div>
                  </div>
                </div>

                {{-- post 2 --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_10px_18px_rgba(0,0,0,.08)] p-6">
                  <div class="flex items-start gap-4">
                    <div class="h-12 w-12 rounded-full bg-gray-200"></div>

                    <div class="flex-1">
                      <div class="flex items-start justify-between gap-4">
                        <div class="leading-tight">
                          <div class="font-extrabold text-gray-900">Juan Dela Cruz</div>
                          <div class="text-sm text-gray-500">@juan_delacruz · 3d ago</div>
                        </div>
                        <button class="text-gray-400 hover:text-gray-600">⋯</button>
                      </div>

                      <div class="mt-3 text-sm text-gray-900">
                        Quick reminder: CCIS Week booth signups are open! 🎉
                        See you all at the campus grounds.
                      </div>

                      <div class="mt-4 h-40 rounded-2xl bg-gray-200"></div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>

          {{-- back link --}}
          <div class="mt-6">
            <a href="{{ route('feed') }}" class="text-[#6C1517] font-semibold hover:underline">
              ← Back to Feed
            </a>
          </div>

        </div>
      </div>
    </main>

  </div>
</div>
@endsection