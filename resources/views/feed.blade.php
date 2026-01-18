@extends('layouts.app')
@section('title','Feed')

{{-- match admin palette --}}
@section('main_class', 'bg-app-page')

@section('content')
@php
$currentUser = auth()->user();
$posts = \App\Models\Post::with(['user', 'comments', 'likes'])
    ->orderBy('created_at', 'desc')
    ->paginate(10);
@endphp

<div class="h-screen overflow-hidden">
  <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-full">

    {{-- CENTER (scroll) --}}
    <section class="px-4 sm:px-6 lg:px-10 py-8 overflow-y-auto">
      <div class="w-full max-w-[840px] mx-auto space-y-5">

        {{-- Header --}}
        <div>
          <div class="text-3xl font-extrabold text-app leading-tight">Community Feed</div>
          <div class="text-sm text-app-muted">Stay updated with the PUP community</div>
        </div>

        {{-- Composer --}}
        <div class="bg-app-card rounded-2xl border border-app shadow-[0_10px_18px_rgba(0,0,0,.08)] overflow-hidden">
          <div class="p-4 flex items-center gap-4">
            <img src="{{ $currentUser->profile_pic ?? 'https://i.pravatar.cc/120?img=' . $currentUser->user_id }}"
              class="h-12 w-12 rounded-full object-cover border border-app"
              alt="avatar" />

            <div class="flex-1">
              <div class="h-11 rounded-full bg-white border border-app flex items-center px-5 text-sm text-app-muted">
                What's on your mind, {{ $currentUser->first_name }}?
              </div>
            </div>
          </div>

          <div class="border-t border-app"></div>

          <div class="px-8 py-4 flex items-center justify-center gap-12 text-sm text-app">
            <a href="{{ route('posts.create') }}" class="flex items-center gap-2 hover:opacity-90">
              <span class="inline-flex h-6 w-6 items-center justify-center rounded bg-emerald-600 text-white text-xs">🖼</span>
              Photo
            </a>
            <a href="{{ route('posts.create') }}" class="flex items-center gap-2 hover:opacity-90">
              <span class="inline-flex h-6 w-6 items-center justify-center rounded bg-amber-600 text-white text-xs">🗓</span>
              Calendar
            </a>
          </div>
        </div>

        {{-- POSTS --}}
        @forelse($posts as $post)
        <div class="bg-app-card rounded-2xl border border-app shadow-[0_10px_18px_rgba(0,0,0,.08)] overflow-hidden">

          <div class="p-5 pb-3">
            <div class="flex items-start justify-between gap-4">
              <div class="flex items-start gap-3">
                <img src="{{ $post->user->profile_pic ?? 'https://i.pravatar.cc/120?img=' . $post->user->user_id }}"
                  class="h-12 w-12 rounded-full object-cover border border-app"
                  alt="avatar" />
                <div class="leading-tight">
                  <div class="font-extrabold text-app">{{ $post->user->first_name }} {{ $post->user->last_name }}</div>
                  <div class="text-sm text-app-muted flex items-center gap-2">
                    <span>@{{ $post->user->username }}</span>
                    <span class="text-gray-300">•</span>
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                  </div>
                </div>
              </div>

              <button type="button" class="text-gray-400 hover:text-gray-600 text-xl leading-none">⋯</button>
            </div>

            <div class="mt-4 text-sm text-app space-y-3">
              <div class="text-app">{{ $post->content }}</div>
            </div>
          </div>

          <div class="px-5 py-3 text-sm text-app-muted flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-[#6C1517] text-white text-[11px]">🔥</span>
              <span>{{ $post->likes()->count() }}</span>
            </div>
            <div>{{ $post->comments()->count() }} comments</div>
          </div>

          <div class="px-5">
            <div class="h-px bg-app-mutedlight/30"></div>
          </div>

          <div class="px-5 py-3 flex items-center justify-around text-sm text-app">
            <form action="{{ route('likes.toggle', $post->post_id) }}" method="POST" class="inline">
              @csrf
              <button type="submit" class="flex items-center gap-2 font-medium hover:text-gray-900">
                {{ $post->isLikedByUser(auth()->user()->user_id) ? '❤️' : '🤍' }} Like
              </button>
            </form>
            <a href="{{ route('posts.show', $post->post_id) }}" class="flex items-center gap-2 font-medium hover:text-gray-900">💬 Comment</a>
          </div>

          <div class="px-5">
            <div class="h-px bg-app-mutedlight/30"></div>
          </div>

          @php
          $topComment = $post->comments()->first();
          @endphp
          @if($topComment)
          <div class="px-5 py-4 flex items-start gap-3">
            <img src="{{ $topComment->user->profile_pic ?? 'https://i.pravatar.cc/120?img=' . $topComment->user->user_id }}"
              class="h-10 w-10 rounded-full object-cover border border-app"
              alt="c-avatar" />

            <div class="bg-white rounded-2xl px-4 py-2 border border-app">
              <div class="text-sm font-semibold text-app">{{ $topComment->user->first_name }} {{ $topComment->user->last_name }}</div>
              <div class="text-sm text-app mt-0.5">{{ $topComment->content }}</div>
            </div>
          </div>
          @endif

          <div class="px-5 pb-5 flex items-center gap-3">
            <img src="{{ $currentUser->profile_pic ?? 'https://i.pravatar.cc/120?img=' . $currentUser->user_id }}"
              class="h-10 w-10 rounded-full object-cover border border-app"
              alt="me" />
            <form action="{{ route('comments.store', $post->post_id) }}" method="POST" class="w-full flex gap-2">
              @csrf
              <input
                type="text"
                name="content"
                placeholder="Write a comment..."
                class="w-full h-10 rounded-full bg-white border border-app px-4 text-sm outline-none placeholder:text-gray-400" />
              <button type="submit" class="px-4 py-2 rounded-full bg-[#6C1517] text-white font-semibold hover:opacity-90">Post</button>
            </form>
          </div>
        </div>
        @empty
        <div class="bg-app-card rounded-2xl border border-app p-8 text-center">
          <p class="text-app-muted">No posts yet. Be the first to share something!</p>
        </div>
        @endforelse

        @if($posts->hasPages())
        <div class="mt-8">
          {{ $posts->links() }}
        </div>
        @endif

      </div>
    </section>

    {{-- RIGHT SIDEBAR --}}
    @include('partials.right-sidebar')

  </div>
</div>
@endsection