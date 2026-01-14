@extends('layouts.app')
@section('title','Feed')

{{-- optional: keep the same background you used --}}
@section('main_class', 'bg-[#F3F3F3]')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-screen overflow-hidden">

  <!-- CENTER FEED (SCROLLABLE ONLY) -->
  <section class="px-4 sm:px-6 lg:px-10 py-8 overflow-y-auto">
    <div class="w-full max-w-[980px] mx-auto space-y-6">

      {{-- Header text --}}
      <div>
        <div class="text-3xl font-extrabold text-gray-900 leading-tight">Community Feed</div>
        <div class="text-sm text-gray-500">Stay updated with the PUP community</div>
      </div>

      {{-- Composer --}}
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

      {{-- MULTIPLE SAMPLE POSTS --}}
      @for ($i = 0; $i < 8; $i++)
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
    @endfor

</div>
</section>

<!-- RIGHT SIDEBAR (UNIFIED PARTIAL) -->
@include('partials.right-sidebar')

</div>
@endsection