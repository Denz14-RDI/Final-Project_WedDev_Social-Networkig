@extends('layouts.app')
@section('title','Feed')

@section('content')
<div class="min-h-screen bg-[#F2EADA]">
  {{-- FULL WIDTH 3-COLUMN LAYOUT --}}
  <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr_340px] min-h-screen">

    <!-- LEFT SIDEBAR (FULL HEIGHT) -->
    <aside class="bg-white border-r border-gray-200 lg:sticky lg:top-0 lg:h-screen">
      <div class="h-full flex flex-col">

        {{-- header --}}
        <div class="px-6 py-5 border-b border-gray-200 flex items-center gap-3">
          <div class="h-11 w-11 rounded-xl bg-[#6C1517] flex items-center justify-center text-white font-extrabold">
            P
          </div>
          <div class="leading-tight">
            <div class="font-extrabold text-gray-900">PUPCOM</div>
            <div class="text-xs text-gray-500">PUP Community</div>
          </div>
        </div>

        {{-- nav --}}
        <nav class="px-4 py-4 space-y-1 flex-1">
          <a href="{{ route('feed') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#6C1517] text-white font-semibold">
            <span class="text-lg">⌂</span>
            Home
          </a>

          <a href="{{ route('search') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 text-gray-800">
            <span class="text-lg">⌕</span>
            Search
          </a>

          <a href="{{ route('notifications') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 text-gray-800">
            <span class="text-lg">🔔</span>
            Notifications
          </a>

          <a href="{{ route('friends') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 text-gray-800">
            <span class="text-lg">👥</span>
            Friends
          </a>

          <a href="{{ route('profile') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 text-gray-800">
            <span class="text-lg">👤</span>
            Profile
          </a>

          <a href="{{ route('settings') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-100 text-gray-800">
            <span class="text-lg">⚙</span>
            Settings
          </a>

          <button
            class="mt-6 w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-[#6C1517] text-white font-semibold hover:opacity-95">
            ✎ Create Post
          </button>
        </nav>

        {{-- user preview --}}
        <div class="px-6 py-5 border-t border-gray-200 flex items-center gap-3">
          <div class="h-11 w-11 rounded-full bg-gray-200"></div>
          <div class="leading-tight">
            <div class="text-sm font-semibold text-gray-900">Juan Dela Cruz</div>
            <div class="text-xs text-gray-500">@juanisko</div>
          </div>
        </div>

      </div>
    </aside>

    <!-- CENTER FEED (COPY THE 2ND PICTURE STYLE) -->
    <main class="bg-[#F5F5F5] px-4 sm:px-6 lg:px-10 py-8">
      {{-- wider + no tiny max width so it fills the column like the reference --}}
      <div class="w-full max-w-[980px] mx-auto space-y-6">

        {{-- Header text (no card) --}}
        <div>
          <div class="text-3xl font-extrabold text-gray-900 leading-tight">Community Feed</div>
          <div class="text-sm text-gray-500">Stay updated with the PUP community</div>
        </div>

        {{-- Composer card (border + shadow like reference) --}}
        <div class="bg-white rounded-2xl border border-gray-300 shadow-[0_10px_18px_rgba(0,0,0,.12)] overflow-hidden">
          <div class="p-5 flex items-center gap-4">
            <div class="h-12 w-12 rounded-full bg-gray-300"></div>

            <div class="flex-1">
              <div class="h-11 rounded-full bg-gray-200/80 flex items-center px-5 text-sm text-gray-600">
                What’s on your mind, Juan?
              </div>
            </div>
          </div>

          <div class="border-t border-gray-300"></div>

          <div class="px-8 py-4 flex items-center justify-center gap-12 text-sm text-gray-700">
            <button class="flex items-center gap-2 hover:opacity-90">
              <span class="inline-flex h-6 w-6 items-center justify-center rounded bg-green-500 text-white text-xs">🖼</span>
              Photo
            </button>

            <button class="flex items-center gap-2 hover:opacity-90">
              <span class="inline-flex h-6 w-6 items-center justify-center rounded bg-orange-500 text-white text-xs">🗓</span>
              Calendar
            </button>

            <button class="flex items-center gap-2 hover:opacity-90">
              <span class="inline-flex h-6 w-6 items-center justify-center rounded bg-blue-600 text-white text-xs">📣</span>
              Announcement
            </button>
          </div>
        </div>

        {{-- Filter pills (grey bar + white active pill) --}}
        <div class="rounded-full bg-gray-200 p-1 flex gap-1 shadow-inner">
          <button class="flex-1 rounded-full bg-white py-2 text-sm font-semibold shadow">
            All
          </button>
          <button class="flex-1 rounded-full py-2 text-sm font-semibold text-gray-700 hover:bg-white/60">
            Announcements
          </button>
          <button class="flex-1 rounded-full py-2 text-sm font-semibold text-gray-700 hover:bg-white/60">
            Events
          </button>
        </div>

        {{-- Post card (border darker + shadow, like the reference) --}}
        <div class="bg-white rounded-2xl border border-gray-300 shadow-[0_10px_18px_rgba(0,0,0,.12)] p-6">
          <div class="flex items-start gap-4">
            <div class="h-12 w-12 rounded-full bg-gray-300"></div>

            <div class="flex-1">
              <div class="flex items-start justify-between gap-4">
                <div class="leading-tight">
                  <div class="font-extrabold text-gray-900">PUP Central Student Organization</div>
                  <div class="text-sm text-gray-500">@pupcentralorg</div>
                </div>

                <div class="flex items-center gap-2">
                  <span class="px-3 py-1 rounded-full text-xs border border-gray-300 text-gray-700 bg-white">
                    Organization
                  </span>
                  <span class="px-3 py-1 rounded-full text-xs border border-yellow-400 text-yellow-700 bg-yellow-50">
                    Event
                  </span>
                </div>
              </div>

              <div class="mt-4 text-sm text-gray-900 space-y-3">
                <div>📣 <span class="font-extrabold">ATTENTION ISKOLAR NG BAYAN!</span></div>
                <div>Join us for the PUP Foundation Day 2025 celebration! 🎉</div>

                <div>
                  <div><span class="font-semibold">Date:</span> October 19, 2025</div>
                  <div><span class="font-semibold">Venue:</span> PUP Main Campus Grounds</div>
                </div>

                <div>
                  Exciting activities await:
                  <ul class="list-disc pl-5 mt-2 space-y-1">
                    <li>Cultural performances</li>
                    <li>Food festival</li>
                    <li>Alumni homecoming</li>
                    <li>Sports competitions</li>
                  </ul>
                </div>

                <div class="font-semibold">
                  See you there! #PUPFoundersDay #IskolarNgBayan
                </div>
              </div>

              <div class="mt-5 h-44 rounded-2xl bg-gray-200 overflow-hidden"></div>
            </div>
          </div>
        </div>

      </div>
    </main>


    <!-- RIGHT SIDE (FULL HEIGHT PANEL) -->
    <aside class="bg-white border-l border-gray-200 lg:sticky lg:top-0 lg:h-screen">
      <div class="h-full flex flex-col px-4 sm:px-6 py-6">
        <div class="space-y-5">

          <div class="bg-white rounded-2xl shadow-[0_18px_40px_rgba(0,0,0,.10)] border border-gray-100 p-6">
            <div class="font-extrabold text-gray-900 mb-4 flex items-center gap-2">
              <span>📌</span> Trending in PUP
            </div>

            <div class="space-y-4 text-sm">
              <div>
                <div class="text-xs text-gray-500">1 · Trending</div>
                <div class="font-semibold">#IskolarNgBayan</div>
                <div class="text-xs text-gray-500">1,234 posts</div>
              </div>
              <div>
                <div class="text-xs text-gray-500">2 · Trending</div>
                <div class="font-semibold">#PUPEnrollment2025</div>
                <div class="text-xs text-gray-500">1,934 posts</div>
              </div>
              <div>
                <div class="text-xs text-gray-500">3 · Trending</div>
                <div class="font-semibold">#finalsweek</div>
                <div class="text-xs text-gray-500">1,234 posts</div>
              </div>
              <div>
                <div class="text-xs text-gray-500">4 · Trending</div>
                <div class="font-semibold">#CCISWeek</div>
                <div class="text-xs text-gray-500">2,234 posts</div>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-2xl shadow-[0_18px_40px_rgba(0,0,0,.10)] border border-gray-100 p-6">
            <div class="font-extrabold text-gray-900 mb-4">Who to follow</div>

            <div class="space-y-4">
              @for ($i = 0; $i < 4; $i++)
                <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <div class="h-10 w-10 rounded-full bg-gray-200"></div>
                  <div class="leading-tight">
                    <div class="text-sm font-semibold text-gray-900">Juan Dela Cruz</div>
                    <div class="text-xs text-gray-500">@juanisko</div>
                  </div>
                </div>
                <button class="px-3 py-1.5 rounded-full bg-gray-100 text-sm font-semibold hover:bg-gray-200">
                  Follow
                </button>
            </div>
            @endfor
          </div>

          <div class="mt-6 text-xs text-gray-500">
            © 2025 PUPCOM · Polytechnic University of the Philippines
          </div>
        </div>

      </div>

      <div class="flex-1"></div>
  </div>
  </aside>

</div>
</div>
@endsection