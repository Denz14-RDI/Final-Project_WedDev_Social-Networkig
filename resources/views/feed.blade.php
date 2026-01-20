@extends('layouts.app')
@section('title','Feed')

@section('main_class', 'bg-app-page')

@section('content')
<div x-data="{ createOpen:false, editMode:false, editPost:{} }"
     @open-edit.window="editMode=true; editPost=$event.detail.post; createOpen=true"
     class="h-screen overflow-hidden">

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
        <button type="button"
                class="w-full text-left bg-app-card rounded-2xl border border-app shadow-app overflow-hidden hover-app transition"
                @click="editMode=false; editPost={}; createOpen=true">
          <div class="p-4 flex items-center gap-4">
            <img src="{{ asset(Auth::user()->profile_pic ?? 'images/default.png') }}"
                 class="h-12 w-12 rounded-full object-cover border border-app" alt="avatar" />
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
                <img src="{{ asset($post->user->profile_pic ?? 'images/default.png') }}"
                     class="h-12 w-12 rounded-full object-cover border border-app" alt="avatar" />
                <div class="leading-tight">
                  <div class="font-extrabold text-app">
                    {{ $post->user->first_name }} {{ $post->user->last_name }}
                  </div>
                  <div class="mt-1 text-sm text-app-muted">
                    {{ '@' . $post->user->username }} · {{ $post->created_at->diffForHumans() }}
                  </div>
                  <div class="text-xs text-app-muted mt-1">
                    📌 {{ ucfirst(str_replace('_',' ', $post->category)) }}
                  </div>
                </div>
              </div>

              {{-- Dropdown --}}
              <div x-data="{ openMenu:false }" class="relative">
                <button type="button"
                        class="h-10 w-10 rounded-xl flex items-center justify-center text-app-muted hover:text-app bg-app-input border border-app"
                        @click="openMenu = !openMenu"
                        aria-label="Post options">
                  ⋯
                </button>

                <div x-show="openMenu"
                     @click.away="openMenu=false"
                     class="absolute right-0 mt-2 w-44 bg-app-card border border-app rounded-xl shadow-lg z-50 origin-top-right">

                  @if(Auth::id() === $post->user_id)
                    {{-- Edit Post --}}
                    <button type="button"
                            @click="$dispatch('open-edit', { post: {{ $post->toJson() }} }); openMenu=false"
                            class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input">
                      <svg class="h-4 w-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                      </svg>
                      Edit Post
                    </button>

                    {{-- Delete Post --}}
                    <form action="{{ route('posts.destroy', $post->post_id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input">
                        <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                          <path d="M6 6h12M9 6v12m6-12v12M4 6h16l-1 14H5L4 6z" />
                        </svg>
                        Delete Post
                      </button>
                    </form>
                  @else
                    {{-- Report (only for non-owners) --}}
                    <button type="button"
                            class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input">
                      <svg class="h-4 w-4 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 9v2m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                      </svg>
                      Report
                    </button>
                  @endif
                </div>
              </div>
            </div>

            <div class="mt-4 text-sm text-app space-y-3">
              <div class="text-app">{{ $post->post_content }}</div>
              @if($post->link)
                <a href="{{ $post->link }}" target="_blank" class="text-app-muted underline">{{ $post->link }}</a>
              @endif
            </div>

            @if($post->image)
            <div class="mt-5 overflow-hidden rounded-2xl bg-app-input border border-app">
              <img src="{{ $post->image }}" alt="post image"
                   class="h-[420px] md:h-[480px] w-full object-cover" loading="lazy" />
            </div>
            @endif
          </div>

          <div class="px-5 py-3 text-sm text-app-muted flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-app-brand text-white text-[11px]">🔥</span>
              <span>0</span>
            </div>
            <div>0 comments</div>
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

  {{-- Create/Edit Post Modal --}}
  @include('partials.create-post-modal')
</div>
@endsection