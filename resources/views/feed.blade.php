@extends('layouts.app')
@section('title','Feed')

@section('main_class', 'bg-app-page')

@section('content')
@php
$demoUser = [
'name' => 'Juan Dela Cruz',
'avatar' => 'https://i.pravatar.cc/120?img=68',
];

$demoPosts = [
[
'name' => 'PUP Central Student Organization',
'handle' => '@pupcentralorg',
'avatar' => 'https://i.pravatar.cc/120?img=32',
'time' => '2h',
'headline' => '📣 ATTENTION ISKOLAR NG BAYAN!',
'body' => 'Join us for the PUP Foundation Day 2025 celebration! 🎉',
'footer' => 'See you there! #PUPFoundersDay #IskolarNgBayan',
'image' => 'https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?auto=format&fit=crop&w=1400&q=60',
'likes' => 128,
'comments' => 24,
'top_comment' => [
'name' => 'Anne Garcia',
'avatar' => 'https://i.pravatar.cc/120?img=47',
'text' => "I'm excited! 🎉 Can't wait! #IskolarNgBayan"
],
],
[
'name' => 'PUP Student Council',
'handle' => '@pupsc',
'avatar' => 'https://i.pravatar.cc/120?img=12',
'time' => 'Yesterday',
'headline' => '📌 REMINDER: Enrollment Updates',
'body' => 'Please check your portal regularly for enrollment schedules and sectioning updates.',
'footer' => '#PUPEnrollment2025',
'image' => null,
'likes' => 77,
'comments' => 10,
'top_comment' => [
'name' => 'Juan Dela Cruz',
'avatar' => 'https://i.pravatar.cc/120?img=68',
'text' => "Got it! Thanks for the reminder. 👍"
],
],
];
@endphp

<div x-data="{ createOpen:false }" class="h-screen overflow-hidden">
  <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-full">

    {{-- CENTER --}}
    <section class="px-4 sm:px-6 lg:px-10 py-8 overflow-y-auto">
      <div class="w-full max-w-[840px] mx-auto space-y-5">

        {{-- Header --}}
        <div>
          <div class="text-3xl font-extrabold text-app leading-tight">Community Feed</div>
          <div class="text-sm text-app-muted">Stay updated with the PUP community</div>
        </div>

        {{-- Composer --}}
        <button
          type="button"
          class="w-full text-left bg-app-card rounded-2xl border border-app shadow-app overflow-hidden hover-app transition"
          @click="createOpen=true">
          <div class="p-4 flex items-center gap-4">
            <img src="{{ $demoUser['avatar'] }}" class="h-12 w-12 rounded-full object-cover border border-app" alt="avatar" />
            <div class="flex-1">
              <div class="h-11 rounded-full bg-app-input border border-app flex items-center px-5 text-sm text-app-muted">
                What’s on your mind, Juan?
              </div>
            </div>
          </div>

          <div class="h-px bg-app-divider"></div>

          <div class="px-8 py-4 flex items-center justify-center gap-12 text-sm text-app">
            <div class="flex items-center gap-2">
              <span class="inline-flex h-6 w-6 items-center justify-center rounded bg-[var(--amber-bg)] text-[var(--amber)] text-xs border border-app">🖼</span>
              Photo
            </div>
            <div class="flex items-center gap-2">
              <span class="inline-flex h-6 w-6 items-center justify-center rounded bg-[var(--amber-bg)] text-[var(--amber)] text-xs border border-app">🗓</span>
              Event
            </div>
          </div>
        </button>

        {{-- POSTS --}}
        @foreach($demoPosts as $post)
        <div class="bg-app-card rounded-2xl border border-app shadow-app overflow-hidden">

          <div class="p-5 pb-3">
            <div class="flex items-start justify-between gap-4">
              <div class="flex items-start gap-3">
                <img src="{{ $post['avatar'] }}" class="h-12 w-12 rounded-full object-cover border border-app" alt="avatar" />
                <div class="leading-tight">
                  <div class="font-extrabold text-app">{{ $post['name'] }}</div>
                  <div class="text-sm text-app-muted flex items-center gap-2">
                    <span>{{ $post['handle'] }}</span>
                    <span class="text-app-mutedlight">•</span>
                    <span>{{ $post['time'] }}</span>
                  </div>
                </div>
              </div>
              <button type="button" class="text-app-muted hover:text-app text-xl leading-none">⋯</button>
            </div>

            <div class="mt-4 text-sm text-app space-y-3">
              <div class="font-extrabold">{{ $post['headline'] }}</div>
              <div class="text-app">{{ $post['body'] }}</div>
              <div class="font-semibold text-app">{{ $post['footer'] }}</div>
            </div>

            @if(!empty($post['image']))
            <div class="mt-5 overflow-hidden rounded-2xl bg-app-input border border-app">
              <img src="{{ $post['image'] }}" alt="post image" class="h-[420px] md:h-[480px] w-full object-cover" loading="lazy" />
            </div>
            @endif
          </div>

          <div class="px-5 py-3 text-sm text-app-muted flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-app-brand text-white text-[11px]">🔥</span>
              <span>{{ $post['likes'] }}</span>
            </div>
            <div>{{ $post['comments'] }} comments</div>
          </div>

          <div class="h-px bg-app-divider mx-5"></div>

          <div class="px-5 py-3 flex items-center justify-around text-sm text-app">
            <button type="button" class="flex items-center gap-2 font-medium hover:opacity-80">👍 Like</button>
            <button type="button" class="flex items-center gap-2 font-medium hover:opacity-80">💬 Comment</button>
          </div>

          <div class="h-px bg-app-divider mx-5"></div>

          <div class="px-5 py-4 flex items-start gap-3">
            <img src="{{ $post['top_comment']['avatar'] }}" class="h-10 w-10 rounded-full object-cover border border-app" alt="c-avatar" />
            <div class="bg-app-input border border-app rounded-2xl px-4 py-2">
              <div class="text-sm font-semibold text-app">{{ $post['top_comment']['name'] }}</div>
              <div class="text-sm text-app mt-0.5">{{ $post['top_comment']['text'] }}</div>
            </div>
          </div>

          <div class="px-5 pb-5 flex items-center gap-3">
            <img src="{{ $demoUser['avatar'] }}" class="h-10 w-10 rounded-full object-cover border border-app" alt="me" />
            <input
              type="text"
              placeholder="Write a comment..."
              class="w-full h-10 rounded-full bg-app-input border border-app px-4 text-sm text-app outline-none placeholder:text-app-muted" />
          </div>
        </div>
        @endforeach

      </div>
    </section>

    {{-- RIGHT SIDEBAR --}}
    @include('partials.right-sidebar')
  </div>

  {{-- Create Post Modal --}}
  @include('partials.create-post-modal')
</div>
@endsection