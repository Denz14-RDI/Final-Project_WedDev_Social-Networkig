@extends('layouts.app')
@section('title','Feed')

@section('main_class', 'bg-app-page')

@section('content')
<div
  x-data="{
    createOpen:false,
    editMode:false,
    editPost:{ post_content:'', image:'', category:'academic', link:'' },
    reportOpen:false,
    reportPost:{}
  }"
  @open-edit.window="
    editMode=true;
    editPost=$event.detail.post;
    createOpen=true
  "
  @open-report.window="
    reportPost=$event.detail.post;
    reportOpen=true
  "
  class="h-screen overflow-hidden"
>
  <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-full">

    {{-- CENTER --}}
    <section class="px-4 sm:px-6 lg:px-10 py-8 overflow-y-auto">
      <div class="w-full max-w-[840px] mx-auto space-y-5">

        {{-- Header --}}
        <div>
          <div class="text-3xl font-extrabold text-app leading-tight">Community Feed</div>
          <div class="text-sm text-app-muted">Stay updated with the PUP community</div>

          @php
            $scope = request('scope');
            $cat = request('category');
          @endphp

          @if($scope === 'all')
            <div class="mt-1 text-xs text-app-muted">
              Exploring {{ $cat ? ucfirst(str_replace('_',' ', $cat)) : 'All Categories' }}
            </div>
          @else
            <div class="mt-1 text-xs text-app-muted">Following</div>
          @endif
        </div>

        {{-- Composer --}}
        <button
          type="button"
          class="w-full text-left bg-app-card rounded-2xl border border-app shadow-app overflow-hidden hover-app transition"
          @click="
            editMode=false;
            editPost={ post_content:'', image:'', category:'academic', link:'' };
            createOpen=true
          "
        >
          <div class="p-4 flex items-center gap-4">
            <img
              src="{{ asset(Auth::user()->profile_pic ?? 'images/default.png') }}"
              class="h-12 w-12 rounded-full object-cover border border-app"
              alt="avatar"
            />
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

                {{-- Left: avatar + meta --}}
                <div class="flex items-start gap-3">
                  <img
                    src="{{ asset($post->user->profile_pic ?? 'images/default.png') }}"
                    class="h-12 w-12 rounded-full object-cover border border-app"
                    alt="avatar"
                  />

                  <div class="leading-tight">
                    <div class="font-extrabold text-app">
                      <a href="{{ route('profile.show', $post->user->user_id) }}" class="hover:underline">
                        {{ $post->user->first_name }} {{ $post->user->last_name }}
                      </a>
                    </div>

                    <div class="mt-1 text-sm text-app-muted">
                      <a href="{{ route('profile.show', $post->user->user_id) }}" class="hover:underline">
                        {{ '@' . $post->user->username }}
                      </a>
                      · {{ $post->created_at->diffForHumans() }}
                    </div>

                    <div class="text-xs text-app-muted mt-1">
                      📌 {{ ucfirst(str_replace('_',' ', $post->category)) }}
                    </div>
                  </div>
                </div>

                {{-- Right: Follow toggle (explore only) + dropdown --}}
                @php
                  $scope = request('scope');
                  $isExplore = ($scope === 'all');

                  // IMPORTANT: your users use user_id, not id
                  $myId = Auth::user()->user_id;
                  $isMine = ((int)$myId === (int)$post->user_id);

                  $status = $followMap[$post->user_id] ?? null;      // follow | following | null
                  $friendId = $followIdMap[$post->user_id] ?? null;  // for unfollow
                @endphp

                <div class="flex items-center gap-2">

                  {{-- Follow toggle (Explore only) --}}
                  @if($isExplore && !$isMine)
                    @if($status === 'following' && $friendId)
                      <form action="{{ route('friends.unfollow', $friendId) }}" method="POST">
                        @csrf
                        <button type="submit"
                          class="h-9 px-4 rounded-full text-sm font-semibold border border-app text-app bg-transparent hover:bg-app-input transition">
                          Following
                        </button>
                      </form>
                    @elseif($status === 'follow')
                      <button type="button" disabled
                        class="h-9 px-4 rounded-full text-sm font-semibold border border-app text-app-muted bg-transparent opacity-70 cursor-not-allowed">
                        Requested
                      </button>
                    @else
                      <form action="{{ route('friends.store', $post->user) }}" method="POST">
                        @csrf
                        <button type="submit"
                          class="h-9 px-4 rounded-full text-sm font-semibold bg-app-brand text-white hover:opacity-90 transition">
                          Follow
                        </button>
                      </form>
                    @endif
                  @endif

                  {{-- Dropdown --}}
                  <div x-data="{ openMenu:false }" class="relative">
                    <button
                      type="button"
                      class="h-10 w-10 rounded-xl flex items-center justify-center text-app-muted hover:text-app bg-app-input border border-app"
                      @click="openMenu = !openMenu"
                      aria-label="Post options"
                    >
                      ⋯
                    </button>

                    <div
                      x-show="openMenu"
                      @click.away="openMenu=false"
                      class="absolute right-0 mt-2 w-44 bg-app-card border border-app rounded-xl shadow-lg z-50 origin-top-right"
                      style="display:none;"
                    >
                      @if((int)$myId === (int)$post->user_id)
                        {{-- Edit Post --}}
                        <button
                          type="button"
                          @click="
                            $dispatch('open-edit', { post: {{ $post->toJson() }} });
                            openMenu=false
                          "
                          class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input"
                        >
                          ✏️ Edit Post
                        </button>

                        {{-- Delete Post --}}
                        <form action="{{ route('posts.destroy', $post->post_id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit"
                            class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input">
                            🗑️ Delete Post
                          </button>
                        </form>
                      @else
                        {{-- Report --}}
                        <button
                          type="button"
                          @click="
                            $dispatch('open-report', { post: {{ $post->toJson() }} });
                            openMenu=false
                          "
                          class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input"
                        >
                          ⚠️ Report
                        </button>
                      @endif
                    </div>
                  </div>

                </div>
              </div>

              {{-- Post content --}}
              <div class="mt-4 text-sm text-app space-y-3">
                <div class="text-app">{{ $post->post_content }}</div>

                @if($post->link)
                  <a href="{{ $post->link }}" target="_blank" class="text-app-muted underline">
                    {{ $post->link }}
                  </a>
                @endif
              </div>

              {{-- Post image --}}
              @if($post->image)
                <div class="mt-5 overflow-hidden rounded-2xl bg-app-input border border-app">
                  <img
                    src="{{ $post->image }}"
                    alt="post image"
                    class="h-[420px] md:h-[480px] w-full object-cover"
                    loading="lazy"
                  />
                </div>
              @endif

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

  {{-- Report Modal --}}
  @include('partials.create-report-modal')

</div>
@endsection
