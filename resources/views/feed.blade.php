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
  class="h-screen overflow-hidden">
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

        @if(empty($singlePost))
        {{-- Composer --}}
        <button
          type="button"
          class="w-full text-left bg-app-card rounded-2xl border border-app shadow-app overflow-hidden hover-app transition"
          @click="
            editMode=false;
            editPost={ post_content:'', image:'', category:'academic', link:'' };
            createOpen=true
          ">
          <div class="p-4 flex items-center gap-4">
            <img
              src="{{ asset(Auth::user()->profile_pic ?? 'images/default.png') }}"
              class="h-12 w-12 rounded-full object-cover border border-app"
              alt="avatar" />
            <div class="flex-1">
              <div class="h-11 rounded-full bg-app-input border border-app flex items-center px-5 text-sm text-app-muted">
                What’s on your mind, {{ Auth::user()->first_name }}?
              </div>
            </div>
          </div>
        </button>
        @endif

        {{-- POSTS --}}
        @forelse($posts as $post)
        <div
          id="post-{{ $post->post_id }}"
          class="bg-app-card rounded-2xl border border-app shadow-app overflow-hidden">

          {{-- Post body --}}
          <div class="p-5 pb-3">
            <div class="flex items-start justify-between gap-4">

              {{-- Left: avatar + meta --}}
              <div class="flex items-start gap-3">
                <img
                  src="{{ asset($post->user->profile_pic ?? 'images/default.png') }}"
                  class="h-12 w-12 rounded-full object-cover border border-app"
                  alt="avatar" />

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

              $myId = Auth::user()->user_id;
              $isMine = ((int)$myId === (int)$post->user_id);

              $status = $followMap[$post->user_id] ?? null; // follow | following | null
              $friendId = $followIdMap[$post->user_id] ?? null; // for unfollow
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
                    aria-label="Post options">
                    ⋯
                  </button>

                  <div
                    x-show="openMenu"
                    x-cloak
                    @click.away="openMenu=false"
                    class="absolute right-0 mt-2 w-44 bg-app-card border border-app rounded-xl shadow-lg z-50 origin-top-right">
                    @if($isMine)
                    <button
                      type="button"
                      @click="
                            $dispatch('open-edit', { post: {{ $post->toJson() }} });
                            openMenu=false
                          "
                      class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input">
                      ✏️ Edit Post
                    </button>

                    <form action="{{ route('posts.destroy', $post->post_id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                        class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input">
                        🗑️ Delete Post
                      </button>
                    </form>
                    @else
                    <button
                      type="button"
                      @click="
                            $dispatch('open-report', { post: {{ $post->toJson() }} });
                            openMenu=false
                          "
                      class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input">
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
                loading="lazy" />
            </div>
            @endif
          </div>

          {{-- FOOTER + COMMENTS (single Alpine scope) --}}
          <div class="px-5 py-3 text-sm text-app-muted"
            x-data="{
                // likes
                count: {{ $post->likes_count ?? 0 }},

                // comments
                commentCount: {{ $post->comments_count ?? 0 }},
                showComments: false,
                comments: [],
                loadingComments: false,
                text: '',

                // edit/delete comment dropdown + edit mode
                authId: {{ Auth::user()->user_id }},
                openCommentMenuId: null,
                editingId: null,
                editText: '',
                commentsBaseUrl: '{{ url('/comments') }}',

                // mark list as outdated when comment was added while closed
                commentsStale: false,

                assetBase: '{{ asset('') }}',
                defaultAvatar: '{{ asset('images/default.png') }}',

                avatarUrl(pic){
                  if (!pic) return this.defaultAvatar;
                  if (pic.startsWith('http')) return pic;
                  if (pic.startsWith('/')) return pic;
                  return this.assetBase + pic;
                },

                async toggleLike() {
                  const res = await fetch('{{ route('posts.like', $post->post_id) }}', {
                    method: 'POST',
                    headers: {
                      'X-CSRF-TOKEN': '{{ csrf_token() }}',
                      'Accept': 'application/json',
                    }
                  });

                  if (!res.ok) return;
                  const data = await res.json();
                  this.count = data.likes_count;
                },

                async toggleComments(){
                  this.showComments = !this.showComments;

                  if (this.showComments && (this.comments.length === 0 || this.commentsStale)){
                    await this.loadComments();
                    this.commentsStale = false;
                  }
                },

                async loadComments(){
                  this.loadingComments = true;

                  const res = await fetch('{{ route('comments.index', $post->post_id) }}', {
                    headers: { 'Accept': 'application/json' }
                  });

                  if (res.ok) this.comments = await res.json();
                  this.loadingComments = false;
                },

                async submitComment(){
                  if (!this.text.trim()) return;

                  const res = await fetch('{{ route('comments.store', $post->post_id) }}', {
                    method: 'POST',
                    headers: {
                      'X-CSRF-TOKEN': '{{ csrf_token() }}',
                      'Accept': 'application/json',
                      'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ com_content: this.text })
                  });

                  if (!res.ok) return;

                  const data = await res.json();

                  if (typeof data.comments_count !== 'undefined') {
                    this.commentCount = data.comments_count;
                  } else {
                    this.commentCount++;
                  }

                  if (this.showComments) {
                    this.comments.unshift(data.comment);
                  } else {
                    this.commentsStale = true;
                  }

                  this.text = '';
                },

                isOwner(c){
                  return (c.user_id ?? c.user?.user_id) == this.authId;
                },

                startEdit(c){
                  this.editingId = c.com_id;
                  this.editText = c.com_content;
                  this.openCommentMenuId = null;
                },

                cancelEdit(){
                  this.editingId = null;
                  this.editText = '';
                },

                async saveEdit(){
                  if (!this.editText.trim() || !this.editingId) return;

                  const res = await fetch(`${this.commentsBaseUrl}/${this.editingId}`, {
                    method: 'PUT',
                    headers: {
                      'X-CSRF-TOKEN': '{{ csrf_token() }}',
                      'Accept': 'application/json',
                      'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ com_content: this.editText })
                  });

                  if (!res.ok) return;

                  const data = await res.json();

                  const idx = this.comments.findIndex(x => x.com_id === data.comment.com_id);
                  if (idx !== -1) this.comments[idx].com_content = data.comment.com_content;

                  this.cancelEdit();
                },

                async deleteComment(c){
                  const id = c.com_id;

                  const res = await fetch(`${this.commentsBaseUrl}/${id}`, {
                    method: 'DELETE',
                    headers: {
                      'X-CSRF-TOKEN': '{{ csrf_token() }}',
                      'Accept': 'application/json',
                    }
                  });

                  if (!res.ok) return;

                  const data = await res.json();

                  this.comments = this.comments.filter(x => x.com_id !== id);

                  if (typeof data.comments_count !== 'undefined') {
                    this.commentCount = data.comments_count;
                  } else {
                    this.commentCount = Math.max(0, this.commentCount - 1);
                  }

                  this.openCommentMenuId = null;
                },
              }">
            {{-- row (likes + clickable comments count) --}}
            <div class="flex items-center justify-between">
              <button type="button" @click="toggleLike()" class="flex items-center gap-2 hover:text-app transition">
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-app-brand text-white text-[11px]">🔥</span>
                <span x-text="count">{{ $post->likes_count ?? 0 }}</span>
              </button>

              <button type="button"
                @click="toggleComments()"
                class="text-sm text-app-muted hover:text-app transition">
                <span x-text="commentCount">{{ $post->comments_count ?? 0 }}</span>
                <span x-text="commentCount == 1 ? ' comment' : ' comments'"></span>
              </button>
            </div>

            {{-- COMMENT INPUT --}}
            <div class="mt-3" @submit.prevent="submitComment()">
              <form class="flex items-center gap-3">
                <input x-model="text"
                  type="text"
                  placeholder="Write a comment..."
                  class="flex-1 h-10 rounded-xl bg-app-input border border-app px-4 text-sm text-app"
                  required />

                <button type="submit" class="rounded-xl btn-brand px-4 h-10 text-sm font-semibold">
                  Comment
                </button>
              </form>
            </div>

            {{-- COMMENTS LIST --}}
            <div x-show="showComments" x-cloak class="mt-4 space-y-3">
              <template x-if="loadingComments">
                <div class="text-xs text-app-muted">Loading comments...</div>
              </template>

              <template x-if="!loadingComments && comments.length === 0">
                <div class="text-xs text-app-muted">No comments yet.</div>
              </template>

              <template x-for="(c, idx) in comments" :key="c.com_id">
                <div class="flex items-start gap-3">
                  <img :src="avatarUrl(c.user?.profile_pic)"
                    class="h-8 w-8 rounded-full object-cover border border-app"
                    alt="avatar" />

                  <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                      <div class="text-xs text-app-muted">
                        <span class="font-semibold text-app"
                          x-text="(c.user?.first_name ?? '') + ' ' + (c.user?.last_name ?? '')"></span>
                        <span class="mx-1">·</span>
                        <span x-text="new Date(c.created_at).toLocaleString()"></span>
                      </div>

                      {{-- 3-dots menu (only owner) --}}
                      <div class="relative" x-show="isOwner(c)">
                        <button type="button"
                          class="h-7 w-7 rounded-lg flex items-center justify-center text-app-muted hover:text-app bg-app-input border border-app"
                          @click="openCommentMenuId = (openCommentMenuId === c.com_id ? null : c.com_id)"
                          aria-label="Comment options">
                          ⋯
                        </button>

                        <div x-show="openCommentMenuId === c.com_id"
                          x-cloak
                          @click.away="openCommentMenuId = null"
                          class="absolute right-0 w-36 bg-app-card border border-app rounded-xl shadow-lg z-[9999] overflow-hidden"
                          :class="idx === comments.length - 1 ? 'bottom-full mb-1' : 'top-full mt-1'">
                          <button type="button"
                            @click="startEdit(c)"
                            class="w-full text-left px-3 py-2 text-xs text-app hover:bg-app-input">
                            ✏️ Edit
                          </button>

                          <button type="button"
                            @click="deleteComment(c)"
                            class="w-full text-left px-3 py-2 text-xs text-app hover:bg-app-input">
                            🗑️ Delete
                          </button>
                        </div>
                      </div>
                    </div>

                    {{-- Edit mode --}}
                    <div x-show="editingId === c.com_id" class="mt-2 space-y-2" x-cloak>
                      <input x-model="editText"
                        class="w-full h-9 rounded-xl bg-app-input border border-app px-3 text-sm text-app" />

                      <div class="flex gap-2">
                        <button type="button"
                          @click="saveEdit()"
                          class="h-8 px-3 rounded-lg btn-brand text-xs font-semibold">
                          Save
                        </button>
                        <button type="button"
                          @click="cancelEdit()"
                          class="h-8 px-3 rounded-lg bg-app-input border border-app text-xs">
                          Cancel
                        </button>
                      </div>
                    </div>

                    {{-- Normal display --}}
                    <div x-show="editingId !== c.com_id" class="text-sm text-app mt-1" x-text="c.com_content"></div>
                  </div>
                </div>
              </template>

            </div>
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