@extends('layouts.app')
@section('title','Search')

@section('main_class', 'bg-app-page')

@section('content')
@php
  $q = request('q', '');
  $authUser = auth()->user();

  // Variables passed from SearchController
  $users = $users ?? collect();
  $friendMap = $friendMap ?? [];
@endphp

<div class="h-screen overflow-hidden">
  <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-full">

    {{-- CENTER (scroll) --}}
    <section class="px-4 sm:px-6 lg:px-10 py-8 overflow-y-auto">
      <div class="w-full max-w-[840px] mx-auto space-y-5">

        {{-- Header --}}
        <div>
          <div class="text-3xl font-extrabold text-app leading-tight">Search</div>
          <div class="text-sm text-app-muted">Find people in PUPCOM</div>
        </div>

        {{-- Search box --}}
        <form action="{{ route('search') }}" method="GET"
          class="bg-app-card rounded-2xl border border-app shadow-app p-4">
          <div class="flex items-center gap-3 h-11 rounded-full bg-app-input border border-app px-5">
            <span class="text-app-muted">🔍</span>
            <input
              type="text"
              name="q"
              value="{{ $q }}"
              placeholder="Search PUPCOM..."
              class="w-full bg-transparent outline-none text-sm text-app placeholder:text-app-mutedlight" />
          </div>
        </form>

        {{-- Results --}}
        <div class="bg-app-card rounded-2xl border border-app shadow-app overflow-hidden">

          <div class="p-6 pb-4 flex items-center justify-between">
            <div class="text-lg font-extrabold flex items-center gap-2 text-app">
              <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-app-brand text-white text-sm">👥</span>
              <span>People</span>
            </div>

            <div class="text-xs text-app-muted">
              {{ method_exists($users, 'total') ? $users->total() : $users->count() }} results
            </div>
          </div>

          <div class="px-6 pb-6 space-y-4">
            @forelse($users as $u)
              @php
                $isMe = $authUser && ($authUser->user_id == $u->user_id);

                $info = $friendMap[$u->user_id] ?? null;
                $status = $info['status'] ?? null;        // following | unfollow | follow | null
                $friendId = $info['friend_id'] ?? null;   // for unfollow route
              @endphp

              <div class="flex items-center justify-between gap-4 rounded-2xl border border-app bg-app-input p-4">

                <div class="flex items-center gap-4 min-w-0">
                  <a href="{{ route('profile.show', $u->user_id) }}">
                    <img
                      class="h-12 w-12 rounded-full object-cover border border-app"
                      src="{{ asset(!empty($u->profile_pic) ? $u->profile_pic : 'images/default.png') }}"
                      alt="avatar">
                  </a>

                  <div class="leading-tight min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                      <div class="font-extrabold text-app truncate">
                        <a href="{{ route('profile.show', $u->user_id) }}" class="hover:underline">
                          {{ $u->first_name }} {{ $u->last_name }}
                        </a>
                      </div>
                    </div>

                    <div class="text-sm text-app-muted">
                      @if(!empty($u->username))
                        <a href="{{ route('profile.show', $u->user_id) }}" class="hover:underline">
                          {{ '@' . $u->username }}
                        </a>
                      @else
                        <span class="italic text-app-mutedlight">No username</span>
                      @endif
                    </div>

                    @if(!empty($u->bio))
                      <div class="text-sm text-app-muted mt-1 line-clamp-2">{{ $u->bio }}</div>
                    @endif
                  </div>
                </div>

                {{-- Action button --}}
                <div class="shrink-0">
                  @if($isMe)
                    <button type="button" disabled
                      class="px-4 py-2 rounded-full btn-ghost text-sm font-semibold opacity-50 cursor-not-allowed">
                      You
                    </button>

                  @elseif($status === 'following')
                    <div class="flex gap-2">
                      <button type="button" disabled
                        class="px-4 py-2 rounded-full btn-ghost text-sm font-semibold opacity-60 cursor-not-allowed">
                        Following
                      </button>

                      {{-- Unfollow --}}
                      <form action="{{ route('friends.unfollow', $friendId) }}" method="POST">
                        @csrf
                        <button type="submit"
                          class="px-4 py-2 rounded-full btn-ghost text-sm font-semibold">
                          Unfollow
                        </button>
                      </form>
                    </div>

                  @else
                    {{-- status null OR unfollow OR follow => show Follow (immediate follow system) --}}
                    <form action="{{ route('friends.store', $u) }}" method="POST">
                      @csrf
                      <button type="submit"
                        class="px-4 py-2 rounded-full btn-ghost text-sm font-semibold">
                        Follow
                      </button>
                    </form>
                  @endif
                </div>

              </div>
            @empty
              <div class="px-6 pb-6">
                <p class="text-app-muted">
                  @if($q)
                    No results found for "{{ $q }}".
                  @else
                    Type something to search.
                  @endif
                </p>
              </div>
            @endforelse
          </div>

          {{-- Pagination --}}
          @if(method_exists($users, 'links'))
            <div class="px-6 pb-6">
              {{ $users->links() }}
            </div>
          @endif

        </div>

      </div>
    </section>

    {{-- RIGHT SIDEBAR --}}
    @include('partials.right-sidebar')

  </div>
</div>
@endsection