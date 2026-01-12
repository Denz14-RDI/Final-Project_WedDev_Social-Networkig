@extends('layouts.app')
@section('title','Feed')

@section('content')
<div class="min-h-screen bg-[var(--bg)]">
  <div class="max-w-6xl mx-auto px-6 py-10">

    <div class="grid grid-cols-12 gap-8 items-start">

      <!-- LEFT SIDEBAR -->
      <aside class="col-span-12 md:col-span-4 lg:col-span-3 relative z-20 pointer-events-auto">
        <div class="bg-white rounded-2xl shadow p-6">
          <div class="font-bold mb-4">PUPCOM</div>

          <nav class="space-y-2">
            <a href="{{ route('feed') }}"
              class="block px-4 py-2 rounded-xl bg-[#6C1517] text-white">
              Home
            </a>

            <a href="{{ route('search') }}"
              class="block px-4 py-2 rounded-xl hover:bg-gray-100">
              Search
            </a>

            <a href="{{ route('notifications') }}"
              class="block px-4 py-2 rounded-xl hover:bg-gray-100">
              Notifications
            </a>

            <a href="{{ route('friends') }}"
              class="block px-4 py-2 rounded-xl hover:bg-gray-100">
              Friends
            </a>

            <a href="{{ route('profile') }}"
              class="block px-4 py-2 rounded-xl hover:bg-gray-100">
              Profile
            </a>
          </nav>

        </div>
      </aside>

      <!-- CENTER FEED -->
      <main class="col-span-12 md:col-span-8 lg:col-span-6 relative z-10">
        <div class="bg-white rounded-2xl shadow p-6">
          <div class="font-bold text-lg">Community Feed</div>
          <div class="text-sm text-gray-500">What's happening today?</div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 mt-6">
          <div class="font-semibold">Sample post</div>
          <div class="text-sm text-gray-600">This is where posts will show.</div>
        </div>
      </main>

      <!-- RIGHT SIDE -->
      <aside class="col-span-12 lg:col-span-3 space-y-6 relative z-10">
        <div class="bg-white rounded-2xl shadow p-6">
          <div class="font-bold mb-2">Trending</div>
          <div class="text-sm text-gray-600 space-y-1">
            <div>#pup</div>
            <div>#events</div>
            <div>#announcements</div>
          </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
          <div class="font-bold mb-2">Who to follow</div>
          <div class="text-sm text-gray-600">Suggested accounts will go here.</div>
        </div>
      </aside>

    </div>
  </div>
</div>
@endsection