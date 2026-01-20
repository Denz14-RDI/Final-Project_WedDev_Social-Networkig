@extends('layouts.app')
@section('title','Profile')
@section('main_class', 'bg-app-page')

@section('content')
<div class="h-screen overflow-hidden">
  <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-full">

    {{-- CENTER --}}
    <main class="h-full overflow-y-auto">
      <div class="px-6 py-10">
        <div class="max-w-[980px] mx-auto">
          <div class="bg-app-card rounded-2xl shadow-app border border-app overflow-hidden">

            {{-- COVER --}}
            <div class="h-44 sm:h-56 bg-gradient-to-r from-[#6C1517] via-[#7B2A2D] to-[#9B5658]"></div>

            <div class="px-8 pb-8">
              <div class="relative pt-10 sm:pt-12">

                {{-- avatar --}}
                <div class="absolute -top-14 sm:-top-16 left-0">
                  <img src="{{ asset($user->profile_pic ?? 'images/default.png') }}"
                    alt="avatar"
                    class="h-32 w-32 sm:h-36 sm:w-36 rounded-full object-cover ring-4 ring-[var(--surface)] border border-app" />
                </div>

                <div class="mt-14 sm:mt-16">
                  <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                      <div class="text-2xl sm:text-3xl font-extrabold text-app leading-tight">
                        {{ $user->first_name }} {{ $user->last_name }}
                      </div>
                      <div class="mt-1 text-sm text-app-muted">{{ '@' . $user->username }}</div>
                    </div>

                    {{-- Edit Profile button only for owner --}}
                    @if($authId === $user->user_id)
                    <button type="button" id="openEditProfile"
                      class="shrink-0 inline-flex items-center justify-center rounded-xl btn-brand px-5 py-2.5 text-sm font-semibold hover:opacity-95 active:opacity-90">
                      Edit Profile
                    </button>
                    @endif
                  </div>

                  <div class="mt-3 text-sm text-app">
                    {{ $user->bio ?? 'No bio yet.' }}
                  </div>

                  <div class="mt-3 flex items-center gap-2 text-sm text-app-muted">
                    <span>📅</span>
                    <span>Joined {{ $user->created_at->format('F Y') }}</span>
                  </div>

                  <div class="mt-4 text-sm text-app">
                    <span class="font-extrabold">{{ $user->iskoolmates ?? 0 }}</span>
                    <span class="ml-1 text-app-muted">Iskoolmates</span>
                  </div>
                </div>
              </div>

              <div class="mt-8 border-t border-app"></div>

              {{-- posts --}}
              <div class="mt-6 space-y-6">
                @forelse($posts as $p)
                <div class="bg-app-card rounded-2xl border border-app shadow-app p-6">
                  <div class="flex items-start gap-4">
                    <img src="{{ asset($user->profile_pic ?? 'images/default.png') }}"
                      class="h-12 w-12 rounded-full object-cover border border-app" alt="me" />

                    <div class="flex-1">
                      <div class="flex items-start justify-between gap-4">
                        <div class="leading-tight">
                          <div class="font-extrabold text-app">{{ $user->first_name }} {{ $user->last_name }}</div>
                          <div class="mt-1 text-sm text-app-muted">
                            {{ '@' . $user->username }} · {{ $p->created_at->diffForHumans() }}
                          </div>
                          {{-- ✅ Show category --}}
                          <div class="text-xs text-app-muted mt-1">
                            📌 {{ ucfirst(str_replace('_',' ', $p->category)) }}
                          </div>
                        </div>
                        @if($authId === $user->user_id)
                        <form action="{{ route('posts.destroy', $p->post_id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button class="text-app-muted hover:text-app">⋯</button>
                        </form>
                        @endif
                      </div>

                      <div class="mt-3 text-sm text-app">{{ $p->post_content }}</div>

                      @if($p->image)
                      <div class="mt-5 overflow-hidden rounded-2xl bg-app-input border border-app">
                        <img src="{{ $p->image }}" class="h-56 sm:h-64 w-full object-cover" alt="post image" loading="lazy">
                      </div>
                      @endif

                      @if($p->link)
                      <div class="mt-2 text-sm text-app-muted">
                        <a href="{{ $p->link }}" target="_blank">{{ $p->link }}</a>
                      </div>
                      @endif
                    </div>
                  </div>

                  {{-- Optional footer for likes/comments --}}
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
            </div>
          </div>
        </div>
      </div>
    </main>

    {{-- RIGHT SIDEBAR --}}
    @include('partials.right-sidebar')

  </div>
</div>

{{-- EDIT PROFILE MODAL only for owner --}}
@if($authId === $user->user_id)
@include('partials.edit-profile-modal')
@endif
@endsection

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const openBtn = document.getElementById('openEditProfile');
    const modal = document.getElementById('editProfileModal');
    const closeBtn = document.getElementById('closeEditProfileBtn');
    const closeBackdrop = document.getElementById('closeEditProfileBackdrop');
    const closeX = document.getElementById('closeEditProfileX');

    if (openBtn && modal) {
      openBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex'); // show as flexbox centered
      });
    }

    function closeModal() {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (closeBackdrop) closeBackdrop.addEventListener('click', closeModal);
    if (closeX) closeX.addEventListener('click', closeModal);
  });
</script>