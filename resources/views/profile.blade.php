@extends('layouts.app')
@section('title','Profile')

{{-- match feed vibe --}}
@section('main_class', 'bg-app-page')

@section('content')
@php
// DEMO USER (replace with Auth::user() later)
$user = auth()->user();
$posts = $user->posts()->with(['comments', 'likes'])->orderBy('created_at', 'desc')->get();
@endphp

<div class="h-screen overflow-hidden">
  <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-full">

    {{-- CENTER (scroll) --}}
    <main class="h-full overflow-y-auto">
      <div class="px-6 py-10">
        <div class="max-w-[980px] mx-auto">

          {{-- profile header card --}}
          <div class="bg-app-card rounded-2xl shadow-[0_18px_40px_rgba(0,0,0,.10)] border border-app overflow-hidden">

            {{-- COVER --}}
            <div class="h-44 sm:h-56 bg-gradient-to-r from-[#6C1517] via-[#7B2A2D] to-[#9B5658]"></div>

            {{-- CONTENT --}}
            <div class="px-8 pb-8">
              <div class="relative pt-10 sm:pt-12">

                {{-- avatar (bigger) --}}
                <div class="absolute -top-14 sm:-top-16 left-0">
                  <img
                    src="{{ $user->profile_pic ?? 'https://i.pravatar.cc/240?img=' . $user->user_id }}"
                    alt="avatar"
                    class="h-32 w-32 sm:h-36 sm:w-36 rounded-full object-cover ring-4 ring-white border border-app" />
                </div>

                {{-- header content --}}
                <div class="mt-14 sm:mt-16">

                  {{-- NAME ROW (Edit button aligned like reference) --}}
                  <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                      <div class="text-2xl sm:text-3xl font-extrabold text-app leading-tight">
                        {{ $user->first_name }} {{ $user->last_name }}
                      </div>
                      <div class="mt-1 text-sm text-app-muted">@{{ $user->username }}</div>
                    </div>

                    {{-- maroon edit button only --}}
                    <button
                      type="button"
                      id="openEditProfile"
                      class="shrink-0 inline-flex items-center justify-center rounded-xl bg-[#6C1517] px-5 py-2.5 text-sm font-semibold text-white hover:opacity-95 active:opacity-90">
                      Edit Profile
                    </button>
                  </div>

                  <div class="mt-3 text-sm text-app">
                    {{ $user->bio }}
                  </div>

                  <div class="mt-3 flex items-center gap-2 text-sm text-app-muted">
                    <span>📅</span>
                    <span>Joined {{ $user->created_at->format('F Y') }}</span>
                  </div>

                  <div class="mt-4 text-sm text-app">
                    <span class="font-extrabold">{{ $user->friends()->count() }}</span>
                    <span class="ml-1 text-app-muted">Friends</span>
                  </div>

                </div>
              </div>

              <div class="mt-8 border-t border-app"></div>

              {{-- posts list (demo) --}}
              <div class="mt-6 space-y-6">
                @foreach($posts as $p)
                <div class="bg-app-card rounded-2xl border border-app shadow-[0_10px_18px_rgba(0,0,0,.08)] p-6">
                  <div class="flex items-start gap-4">
                    <img src="{{ $user['avatar'] }}" class="h-12 w-12 rounded-full object-cover border border-app" alt="me" />

                    <div class="flex-1">
                      <div class="flex items-start justify-between gap-4">
                        <div class="leading-tight">
                          <div class="font-extrabold text-app">{{ $user['name'] }}</div>
                          <div class="text-sm text-app-muted">{{ $user['handle'] }} · {{ $p['time'] }}</div>
                        </div>
                        <button class="text-app-muted hover:text-app">⋯</button>
                      </div>

                      <div class="mt-3 text-sm text-app">
                        {!! $p['text'] !!}
                      </div>

                      @if(!empty($p['image']))
                      <div class="mt-5 overflow-hidden rounded-2xl bg-[#F3F4F6] border border-app">
                        <img src="{{ $p['image'] }}" class="h-56 sm:h-64 w-full object-cover" alt="post image" loading="lazy">
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
                @endforeach
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

{{-- EDIT PROFILE MODAL --}}
<div
  id="editProfileModal"
  class="fixed inset-0 z-[999] hidden items-center justify-center px-4">

  {{-- backdrop --}}
  <button
    type="button"
    id="closeEditProfileBackdrop"
    class="absolute inset-0 bg-black/40"></button>

  {{-- modal card --}}
  <div class="relative w-full max-w-lg rounded-2xl bg-white shadow-[0_22px_60px_rgba(0,0,0,.30)] border border-black/10 overflow-hidden">
    <div class="px-6 py-5 border-b border-black/10 flex items-start justify-between gap-4">
      <div>
        <div class="text-lg font-extrabold text-gray-900">Edit Profile</div>
        <div class="text-sm text-gray-500">Make changes to your profile information.</div>
      </div>

      <button type="button" id="closeEditProfileX" class="h-9 w-9 rounded-xl hover:bg-black/5 text-gray-600 grid place-items-center">
        <span class="text-xl leading-none">×</span>
      </button>
    </div>

    <form class="p-6 space-y-5" action="#" method="POST">
      @csrf

      <div class="flex items-center justify-center">
        <div class="relative">
          <img src="{{ $user['avatar'] }}" class="h-24 w-24 rounded-full object-cover border border-gray-200" alt="avatar">
          <div class="absolute -bottom-1 -right-1 h-9 w-9 rounded-full bg-[#6C1517] text-white grid place-items-center shadow">
            <span class="text-sm">📷</span>
          </div>
        </div>
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-800 mb-2">Avatar URL</label>
        <input
          type="text"
          name="avatar"
          value="{{ $user['avatar'] }}"
          class="w-full rounded-xl bg-white px-4 py-3 text-sm ring-1 ring-gray-200 outline-none focus:ring-2 focus:ring-[#6C1517]" />
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-800 mb-2">Display Name</label>
        <input
          type="text"
          name="name"
          value="{{ $user['name'] }}"
          class="w-full rounded-xl bg-white px-4 py-3 text-sm ring-1 ring-gray-200 outline-none focus:ring-2 focus:ring-[#6C1517]" />
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-800 mb-2">Bio</label>
        <textarea
          name="bio"
          rows="3"
          maxlength="160"
          class="w-full rounded-xl bg-white px-4 py-3 text-sm ring-1 ring-gray-200 outline-none focus:ring-2 focus:ring-[#6C1517]">{{ $user['bio'] }}</textarea>
        <div class="mt-2 text-xs text-gray-500 text-right"><span id="bioCount">0</span>/160</div>
      </div>

      <div class="pt-2 flex items-center justify-end gap-3">
        <button
          type="button"
          id="closeEditProfileBtn"
          class="rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-semibold hover:bg-gray-50">
          Cancel
        </button>

        <button
          type="submit"
          class="rounded-xl bg-[#6C1517] px-5 py-2.5 text-sm font-semibold text-white hover:opacity-95 active:opacity-90">
          Save Changes
        </button>
      </div>
    </form>
  </div>
</div>

{{-- tiny modal JS (no dependencies) --}}
<script>
  (function() {
    const modal = document.getElementById('editProfileModal');
    const openBtn = document.getElementById('openEditProfile');
    const closeX = document.getElementById('closeEditProfileX');
    const closeBtn = document.getElementById('closeEditProfileBtn');
    const closeBackdrop = document.getElementById('closeEditProfileBackdrop');

    const bio = modal.querySelector('textarea[name="bio"]');
    const bioCount = document.getElementById('bioCount');

    function setBioCount() {
      if (!bioCount || !bio) return;
      bioCount.textContent = String(bio.value.length);
    }

    function openModal() {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.body.classList.add('overflow-hidden');
      setBioCount();
      const first = modal.querySelector('input[name="avatar"]');
      if (first) setTimeout(() => first.focus(), 0);
    }

    function closeModal() {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      document.body.classList.remove('overflow-hidden');
    }

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeX) closeX.addEventListener('click', closeModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (closeBackdrop) closeBackdrop.addEventListener('click', closeModal);

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
    });

    if (bio) bio.addEventListener('input', setBioCount);
    setBioCount();
  })();
</script>
@endsection