@extends('layouts.app')
@section('title','Feed')

@section('main_class', 'bg-app-page')

@section('content')
<div x-data="{ createOpen:false, editMode:false, editPost:{}, reportOpen:false, reportPost:{} }"
  @open-edit.window="editMode=true; editPost=$event.detail.post; createOpen=true"
  @open-report.window="reportPost=$event.detail.post; reportOpen=true"
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
                  {{-- Report (only for non-owners) --}}
                  <button type="button"
                    @click="$dispatch('open-report', { post: {{ $post->toJson() }} }); openMenu=false"
                    class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input">
                    ⚠️ Report
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
  <div x-show="createOpen"
    x-transition.opacity
    class="fixed inset-0 z-[999] flex items-center justify-center px-4"
    style="display:none;"
    @keydown.escape.window="createOpen=false">

    {{-- backdrop --}}
    <button type="button"
      class="absolute inset-0 bg-black/50"
      @click="createOpen=false"
      aria-label="Close modal"></button>

    {{-- modal --}}
    <div class="relative w-full max-w-xl bg-app-card border border-app rounded-2xl shadow-app overflow-hidden">

      {{-- header --}}
      <div class="px-6 py-5 border-b border-app flex items-center justify-between gap-3">
        <div>
          <div class="text-lg font-extrabold text-app" x-text="editMode ? 'Edit Post' : 'Create Post'"></div>
          <div class="text-sm text-app-muted" x-text="editMode ? 'Update your post details.' : 'Share something with the PUP community.'"></div>
        </div>
        <button type="button"
          class="h-10 w-10 rounded-xl hover-app grid place-items-center text-app-muted"
          title="Close"
          @click="createOpen=false">
          <span class="text-xl leading-none">×</span>
        </button>
      </div>

      {{-- form --}}
      <form class="p-6 space-y-5"
        method="POST"
        :action="editMode ? '/posts/' + editPost.post_id : '{{ route('posts.store') }}'">

        @csrf
        <template x-if="editMode">
          <input type="hidden" name="_method" value="PUT">
        </template>

        {{-- content --}}
        <div>
          <label class="block text-sm font-semibold text-app mb-2">What’s on your mind?</label>
          <textarea name="post_content"
            rows="4"
            x-model="editMode ? editPost.post_content : ''"
            class="w-full rounded-2xl bg-app-input border border-app px-4 py-3 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)] placeholder:text-app-muted"
            placeholder="Write something..." required></textarea>
        </div>

        {{-- attachment --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold text-app mb-2">Photo URL (optional)</label>
            <input type="url" name="image"
              x-model="editMode ? editPost.image : ''"
              class="w-full rounded-xl bg-app-input border border-app px-4 py-3 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)] placeholder:text-app-muted"
              placeholder="https://..." />
          </div>

          <div>
            <label class="block text-sm font-semibold text-app mb-2">Category</label>
            <select name="category"
              x-model="editMode ? editPost.category : ''"
              class="w-full rounded-xl bg-app-input border border-app px-4 py-3 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)]"
              required>
              <option value="academic">Academic</option>
              <option value="events">Events</option>
              <option value="announcement">Announcement</option>
              <option value="campus_life">Campus Life</option>
              <option value="help_wanted">Help Wanted</option>
            </select>

          </div>
        </div>

        {{-- link --}}
        <div>
          <label class="block text-sm font-semibold text-app mb-2">Link (optional)</label>
          <input type="url" name="link"
            x-model="editMode ? editPost.link : ''"
            class="w-full rounded-xl bg-app-input border border-app px-4 py-3 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)] placeholder:text-app-muted"
            placeholder="https://..." />
        </div>

        {{-- footer buttons --}}
        <div class="pt-2 flex items-center justify-end gap-3">
          <button type="button"
            class="rounded-xl btn-ghost px-5 py-2.5 text-sm font-semibold"
            @click="createOpen=false">
            Cancel
          </button>

          <button type="submit"
            class="rounded-xl btn-brand px-5 py-2.5 text-sm font-semibold hover:opacity-95 active:opacity-90"
            x-text="editMode ? 'Update' : 'Post'">
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- Report Modal --}}
  @include('partials.create-report-modal')

</div>
@endsection