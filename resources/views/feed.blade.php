@extends('layouts.app')
@section('title','Feed')

@section('main_class', 'bg-app-page')

@section('content')
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
            <img src="{{ Auth::user()->profile_pic ?? 'images/default.png' }}" class="h-12 w-12 rounded-full object-cover border border-app" alt="avatar" />
            <div class="flex-1">
              <div class="h-11 rounded-full bg-app-input border border-app flex items-center px-5 text-sm text-app-muted">
                What’s on your mind, {{ Auth::user()->first_name }}?
              </div>
            </div>
          </div>
        </button>

        {{-- POSTS --}}
        @forelse($posts as $post)
        <div class="bg-app-card rounded-2xl border border-app shadow-app overflow-hidden">

          <div class="p-5 pb-3">
            <div class="flex items-start justify-between gap-4">
              <div class="flex items-start gap-3">
                <img src="{{ $post->user->profile_pic ?? 'images/default.png' }}" class="h-12 w-12 rounded-full object-cover border border-app" alt="avatar" />
                <div class="leading-tight">
                  <div class="font-extrabold text-app">{{ $post->user->first_name }} {{ $post->user->last_name }}</div>
                  <div class="text-sm text-app-muted flex items-center gap-2">
                    <span>@{{ $post->user->username }}</span>
                    <span class="text-app-mutedlight">•</span>
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                  </div>
                </div>
              </div>
              @if(Auth::id() === $post->user_id)
                <form action="{{ route('posts.destroy', $post->post_id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-app-muted hover:text-app text-xl leading-none">⋯</button>
                </form>
              @else
                <button type="button" class="text-app-muted hover:text-app text-xl leading-none">⋯</button>
              @endif
            </div>

            <div class="mt-4 text-sm text-app space-y-3">
              <div class="text-app">{{ $post->post_content }}</div>
              @if($post->link)
                <a href="{{ $post->link }}" target="_blank" class="text-app-muted underline">{{ $post->link }}</a>
              @endif
            </div>

            @if($post->image)
            <div class="mt-5 overflow-hidden rounded-2xl bg-app-input border border-app">
              <img src="{{ $post->image }}" alt="post image" class="h-[420px] md:h-[480px] w-full object-cover" loading="lazy" />
            </div>
            @endif
          </div>

          <div class="px-5 py-3 text-sm text-app-muted flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-app-brand text-white text-[11px]">🔥</span>
              <span>0</span> {{-- likes placeholder --}}
            </div>
            <div>0 comments</div> {{-- comments placeholder --}}
          </div>
        </div>
        @empty
          <p class="text-center text-app-muted">No posts yet.</p>
        @endforelse

      </div>
    </section>

    {{-- RIGHT SIDEBAR --}}
    @include('partials.right-sidebar')
  </div>

  {{-- Create Post Modal --}}
  @include('partials.create-post-modal')
</div>
@endsection