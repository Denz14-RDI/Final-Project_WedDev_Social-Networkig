@extends('layouts.app')
@section('title','Profile')
@section('main_class', 'bg-app-page')

@section('content')
<div x-data="{ createOpen:false, editMode:false, editPost:{}, reportOpen:false, reportPost:{} }"
     @open-edit.window="editMode=true; editPost=$event.detail.post; createOpen=true"
     @open-report.window="reportPost=$event.detail.post; reportOpen=true"
     class="h-screen overflow-hidden">

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
                      <div class="mt-1 text-sm text-app-muted">
                        {{ '@' . $user->username }}
                      </div>
                    </div>

                    {{-- Conditional button --}}
                    @if($authId === $user->user_id)
                      <button type="button" id="openEditProfile"
                              class="shrink-0 inline-flex items-center justify-center rounded-xl btn-brand px-5 py-2.5 text-sm font-semibold hover:opacity-95 active:opacity-90">
                        ✏️ Edit Profile
                      </button>
                    @else
                      @if(!empty($isFollowing) && !empty($friendId))
                        <form action="{{ route('friends.unfollow', $friendId) }}" method="POST">
                          @csrf
                          <button type="submit"
                                  class="shrink-0 inline-flex items-center justify-center rounded-xl btn-ghost px-5 py-2.5 text-sm font-semibold hover:opacity-95 active:opacity-90">
                            🚫 Unfollow
                          </button>
                        </form>
                      @else
                        <form action="{{ route('friends.store', $user) }}" method="POST">
                          @csrf
                          <button type="submit"
                                  class="shrink-0 inline-flex items-center justify-center rounded-xl btn-brand px-5 py-2.5 text-sm font-semibold hover:opacity-95 active:opacity-90">
                            ➕ Follow
                          </button>
                        </form>
                      @endif
                    @endif
                  </div>

                  {{-- bio --}}
                  <div class="mt-3 text-sm text-app">
                    {{ $user->bio ?? 'No bio yet.' }}
                  </div>

                  {{-- joined --}}
                  <div class="mt-3 flex items-center gap-2 text-sm text-app-muted">
                    <span>📅</span>
                    <span>Joined {{ $user->created_at->format('F Y') }}</span>
                  </div>

                  {{-- FOLLOWERS / FOLLOWING --}}
                  <div class="mt-5 flex items-center gap-8 text-sm">
                    <button type="button" id="openFollowersModal"
                            class="group inline-flex items-center gap-2 text-app hover:opacity-95 transition">
                      <span class="font-extrabold text-app text-base">
                        {{ $followersCount ?? 0 }}
                      </span>
                      <span class="text-app-muted group-hover:underline underline-offset-4">
                        Followers
                      </span>
                    </button>

                    <button type="button" id="openFollowingModal"
                            class="group inline-flex items-center gap-2 text-app hover:opacity-95 transition">
                      <span class="font-extrabold text-app text-base">
                        {{ $followingCount ?? 0 }}
                      </span>
                      <span class="text-app-muted group-hover:underline underline-offset-4">
                        Following
                      </span>
                    </button>
                  </div>

                </div>
              </div>

              {{-- Divider --}}
              <div class="mt-8 border-t border-app"></div>

              {{-- POSTS --}}
              <div class="mt-6 space-y-6">
                @forelse($posts as $p)
                  <div class="bg-app-card rounded-2xl border border-app shadow-app overflow-hidden">

                    <div class="p-6">
                      <div class="flex items-start gap-4">
                        <img src="{{ asset($user->profile_pic ?? 'images/default.png') }}"
                             class="h-12 w-12 rounded-full object-cover border border-app"
                             alt="me" />

                        <div class="flex-1">
                          <div class="flex items-start justify-between gap-4">

                            <div class="leading-tight">
                              <div class="font-extrabold text-app">
                                {{ $user->first_name }} {{ $user->last_name }}
                              </div>

                              <div class="mt-1 text-sm text-app-muted">
                                {{ '@' . $user->username }} · {{ $p->created_at->diffForHumans() }}
                              </div>

                              <div class="text-xs text-app-muted mt-1">
                                📌 {{ ucfirst(str_replace('_',' ', $p->category)) }}
                              </div>
                            </div>

                            {{-- dropdown --}}
                            <div x-data="{ openMenu:false }" class="relative shrink-0">
                              <button type="button"
                                      class="h-8 w-8 rounded-xl flex items-center justify-center text-app-muted hover:text-app bg-app-input border border-app"
                                      @click="openMenu = !openMenu"
                                      aria-label="Post options">
                                ⋯
                              </button>

                              <div x-show="openMenu"
                                   @click.away="openMenu=false"
                                   class="absolute right-0 mt-2 w-44 bg-app-card border border-app rounded-xl shadow-lg z-50 origin-top-right">

                                @if($authId === $user->user_id)
                                  <button type="button"
                                          @click="$dispatch('open-edit', { post: {{ $p->toJson() }} }); openMenu=false"
                                          class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input">
                                    ✏️ Edit Post
                                  </button>

                                  <form action="{{ route('posts.destroy', $p->post_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input">
                                      🗑️ Delete Post
                                    </button>
                                  </form>
                                @else
                                  <button type="button"
                                          @click="$dispatch('open-report', { post: {{ $p->toJson() }} }); openMenu=false"
                                          class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input">
                                    ⚠️ Report
                                  </button>
                                @endif

                              </div>
                            </div>

                          </div>

                          <div class="mt-3 text-sm text-app">
                            {{ $p->post_content }}
                          </div>

                          @if($p->image)
                            <div class="mt-5 overflow-hidden rounded-2xl bg-app-input border border-app">
                              <img src="{{ $p->image }}"
                                   class="h-56 sm:h-64 w-full object-cover"
                                   alt="post image"
                                   loading="lazy">
                            </div>
                          @endif

                          @if($p->link)
                            <div class="mt-2 text-sm text-app-muted">
                              <a href="{{ $p->link }}" target="_blank" class="underline">
                                {{ $p->link }}
                              </a>
                            </div>
                          @endif

                        </div>
                      </div>
                    </div>

                    <div class="px-6 py-3 text-sm text-app-muted flex items-center justify-between border-t border-app">
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

{{-- ✅ FOLLOWERS/FOLLOWING MODALS --}}
@include('partials.profile-followers-modal')
@include('partials.profile-following-modal')

{{-- ✅ EDIT PROFILE MODAL --}}
@if($authId === $user->user_id)
  @include('partials.edit-profile-modal')
@endif

{{-- Report Modal --}}
@include('partials.create-report-modal')

{{-- ✅ Modals open/close JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ===== Followers modal =====
  const followersModal = document.getElementById('followersModal');
  const openFollowers = document.getElementById('openFollowersModal');
  const closeFollowersBackdrop = document.getElementById('closeFollowersBackdrop');
  const closeFollowersX = document.getElementById('closeFollowersX');

  const showFollowers = () => followersModal && followersModal.classList.remove('hidden');
  const hideFollowers = () => followersModal && followersModal.classList.add('hidden');

  openFollowers && openFollowers.addEventListener('click', showFollowers);
  closeFollowersBackdrop && closeFollowersBackdrop.addEventListener('click', hideFollowers);
  closeFollowersX && closeFollowersX.addEventListener('click', hideFollowers);


  // ===== Following modal =====
  const followingModal = document.getElementById('followingModal');
  const openFollowing = document.getElementById('openFollowingModal');
  const closeFollowingBackdrop = document.getElementById('closeFollowingBackdrop');
  const closeFollowingX = document.getElementById('closeFollowingX');

  const showFollowing = () => followingModal && followingModal.classList.remove('hidden');
  const hideFollowing = () => followingModal && followingModal.classList.add('hidden');

  openFollowing && openFollowing.addEventListener('click', showFollowing);
  closeFollowingBackdrop && closeFollowingBackdrop.addEventListener('click', hideFollowing);
  closeFollowingX && closeFollowingX.addEventListener('click', hideFollowing);


  // ===== Edit Profile modal (FIX) =====
  const editProfileModal = document.getElementById('editProfileModal');
  const openEditProfile = document.getElementById('openEditProfile');
  const closeEditProfileBackdrop = document.getElementById('closeEditProfileBackdrop');
  const closeEditProfileX = document.getElementById('closeEditProfileX');
  const closeEditProfileBtn = document.getElementById('closeEditProfileBtn');

  const showEditProfile = () => editProfileModal && editProfileModal.classList.remove('hidden');
  const hideEditProfile = () => editProfileModal && editProfileModal.classList.add('hidden');

  openEditProfile && openEditProfile.addEventListener('click', showEditProfile);
  closeEditProfileBackdrop && closeEditProfileBackdrop.addEventListener('click', hideEditProfile);
  closeEditProfileX && closeEditProfileX.addEventListener('click', hideEditProfile);
  closeEditProfileBtn && closeEditProfileBtn.addEventListener('click', hideEditProfile);

});
</script>

@endsection
