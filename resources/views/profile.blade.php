@extends('layouts.app')
@section('title','Profile')
@section('main_class', 'bg-app-page')

@section('content')
<div
  x-data="{
    createOpen:false,
    editMode:false,
    editPost:{},
    reportOpen:false,
    reportPost:{},

    // ✅ Alpine-driven modals (no more brittle JS/IDs)
    editProfileOpen:false,
    followersOpen:false,
    followingOpen:false,
  }"
  @open-edit.window="editMode=true; editPost=$event.detail.post; createOpen=true"
  @open-report.window="reportPost=$event.detail.post; reportOpen=true"
  class="h-screen overflow-hidden"
>

  <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-full">

    {{-- CENTER --}}
    <main class="h-full overflow-y-auto">
      <div class="px-4 sm:px-6 py-8 sm:py-10">
        <div class="max-w-[980px] mx-auto">
          <div class="bg-app-card rounded-2xl shadow-app border border-app overflow-hidden">

            {{-- COVER --}}
            <div class="h-36 sm:h-56 bg-gradient-to-r from-[#6C1517] via-[#7B2A2D] to-[#9B5658]"></div>

            <div class="px-4 sm:px-8 pb-6 sm:pb-8">
              <div class="relative pt-10 sm:pt-12">

                {{-- avatar --}}
                <div class="absolute -top-12 sm:-top-16 left-0">
                  <img
                    src="{{ asset($user->profile_pic ?? 'images/default.png') }}"
                    alt="avatar"
                    class="h-24 w-24 sm:h-36 sm:w-36 rounded-full object-cover ring-4 ring-[var(--surface)] border border-app"
                  />
                </div>

                <div class="mt-12 sm:mt-16">
                  <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="min-w-0">
                      <div class="text-xl sm:text-3xl font-extrabold text-app leading-tight truncate">
                        {{ $user->first_name }} {{ $user->last_name }}
                      </div>
                      <div class="mt-1 text-sm text-app-muted truncate">
                        {{ '@' . $user->username }}
                      </div>
                    </div>

                    {{-- Conditional button --}}
                    <div class="shrink-0">
                      @if($authId === $user->user_id)
                        <button
                          type="button"
                          @click="editProfileOpen=true"
                          class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl btn-brand px-5 py-2.5 text-sm font-semibold hover:opacity-95 active:opacity-90"
                        >
                          ✏️ Edit Profile
                        </button>
                      @else
                        @if(!empty($isFollowing) && !empty($friendId))
                          <form action="{{ route('friends.unfollow', $friendId) }}" method="POST">
                            @csrf
                            <button
                              type="submit"
                              class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl btn-ghost px-5 py-2.5 text-sm font-semibold hover:opacity-95 active:opacity-90"
                            >
                              🚫 Unfollow
                            </button>
                          </form>
                        @else
                          <form action="{{ route('friends.store', $user) }}" method="POST">
                            @csrf
                            <button
                              type="submit"
                              class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl btn-brand px-5 py-2.5 text-sm font-semibold hover:opacity-95 active:opacity-90"
                            >
                              ➕ Follow
                            </button>
                          </form>
                        @endif
                      @endif
                    </div>
                  </div>

                  {{-- bio --}}
                  <div class="mt-3 text-sm text-app break-words">
                    {{ $user->bio ?? 'No bio yet.' }}
                  </div>

                  {{-- joined --}}
                  <div class="mt-3 flex items-center gap-2 text-sm text-app-muted">
                    <span>📅</span>
                    <span>Joined {{ $user->created_at->format('F Y') }}</span>
                  </div>

                  {{-- FOLLOWERS / FOLLOWING --}}
                  <div class="mt-5 flex flex-wrap items-center gap-6 sm:gap-8 text-sm">
                    <button
                      type="button"
                      @click="followersOpen=true"
                      class="group inline-flex items-center gap-2 text-app hover:opacity-95 transition"
                    >
                      <span class="font-extrabold text-app text-base">
                        {{ $followersCount ?? 0 }}
                      </span>
                      <span class="text-app-muted group-hover:underline underline-offset-4">
                        Followers
                      </span>
                    </button>

                    <button
                      type="button"
                      @click="followingOpen=true"
                      class="group inline-flex items-center gap-2 text-app hover:opacity-95 transition"
                    >
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

                    <div class="p-4 sm:p-6">
                      <div class="flex items-start gap-4">
                        <img
                          src="{{ asset($user->profile_pic ?? 'images/default.png') }}"
                          class="h-12 w-12 rounded-full object-cover border border-app"
                          alt="me"
                        />

                        <div class="flex-1 min-w-0">
                          <div class="flex items-start justify-between gap-4">

                            <div class="leading-tight min-w-0">
                              <div class="font-extrabold text-app truncate">
                                {{ $user->first_name }} {{ $user->last_name }}
                              </div>

                              <div class="mt-1 text-sm text-app-muted truncate">
                                {{ '@' . $user->username }} · {{ $p->created_at->diffForHumans() }}
                              </div>

                              <div class="text-xs text-app-muted mt-1 truncate">
                                📌 {{ ucfirst(str_replace('_',' ', $p->category)) }}
                              </div>
                            </div>

                            {{-- dropdown --}}
                            <div x-data="{ openMenu:false }" class="relative shrink-0">
                              <button
                                type="button"
                                class="h-8 w-8 rounded-xl flex items-center justify-center text-app-muted hover:text-app bg-app-input border border-app"
                                @click="openMenu = !openMenu"
                                aria-label="Post options"
                              >
                                ⋯
                              </button>

                              <div
                                x-show="openMenu"
                                x-cloak
                                @click.away="openMenu=false"
                                class="absolute right-0 mt-2 w-44 bg-app-card border border-app rounded-xl shadow-lg z-50 origin-top-right"
                              >
                                @if($authId === $user->user_id)
                                  <button
                                    type="button"
                                    @click="$dispatch('open-edit', { post: {{ $p->toJson() }} }); openMenu=false"
                                    class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input"
                                  >
                                    ✏️ Edit Post
                                  </button>

                                  <form action="{{ route('posts.destroy', $p->post_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                      type="submit"
                                      class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input"
                                    >
                                      🗑️ Delete Post
                                    </button>
                                  </form>
                                @else
                                  <button
                                    type="button"
                                    @click="$dispatch('open-report', { post: {{ $p->toJson() }} }); openMenu=false"
                                    class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-app hover:bg-app-input"
                                  >
                                    ⚠️ Report
                                  </button>
                                @endif
                              </div>
                            </div>

                          </div>

                          <div class="mt-3 text-sm text-app break-words">
                            {{ $p->post_content }}
                          </div>

                          @if($p->image)
                            <div class="mt-5 overflow-hidden rounded-2xl bg-app-input border border-app">
                              <img
                                src="{{ $p->image }}"
                                class="h-56 sm:h-64 w-full object-cover"
                                alt="post image"
                                loading="lazy"
                              >
                            </div>
                          @endif

                          @if($p->link)
                            <div class="mt-2 text-sm text-app-muted break-all">
                              <a href="{{ $p->link }}" target="_blank" class="underline">
                                {{ $p->link }}
                              </a>
                            </div>
                          @endif

                        </div>
                      </div>
                    </div>

                    {{-- FOOTER + COMMENTS (single Alpine scope) --}}
                    <div class="px-5 py-3 text-sm text-app-muted"
                      x-data="{
                        // likes
                        count: {{ $p->likes_count ?? 0 }},

                        // comments
                        commentCount: {{ $p->comments_count ?? 0 }},
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
                          const res = await fetch('{{ route('posts.like', $p->post_id) }}', {
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
                          const res = await fetch('{{ route('comments.index', $p->post_id) }}', {
                            headers: { 'Accept': 'application/json' }
                          });
                          if (res.ok) this.comments = await res.json();
                          this.loadingComments = false;
                        },

                        async submitComment(){
                          if (!this.text.trim()) return;

                          const res = await fetch('{{ route('comments.store', $p->post_id) }}', {
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
                      }"
                    >

                      {{-- row (likes + clickable comments count) --}}
                      <div class="flex items-center justify-between">
                        <button type="button" @click="toggleLike()" class="flex items-center gap-2 hover:text-app transition">
                          <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-app-brand text-white text-[11px]">🔥</span>
                          <span x-text="count">{{ $p->likes_count ?? 0 }}</span>
                        </button>

                        {{-- clickable comment count --}}
                        <button type="button"
                          @click="toggleComments()"
                          class="text-sm text-app-muted hover:text-app transition">
                          <span x-text="commentCount">{{ $p->comments_count ?? 0 }}</span>
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
                            required
                          />
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
                              alt="avatar"
                            />

                            <div class="flex-1 min-w-0">
                              <div class="flex items-start justify-between gap-2">
                                <div class="text-xs text-app-muted min-w-0">
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
                                  class="w-full h-9 rounded-xl bg-app-input border border-app px-3 text-sm text-app"
                                />

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

                              {{-- Normal display mode --}}
                              <div x-show="editingId !== c.com_id" class="text-sm text-app mt-1 break-words" x-text="c.com_content"></div>
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

            </div>
          </div>
        </div>
      </div>
    </main>

    {{-- RIGHT SIDEBAR --}}
    @include('partials.right-sidebar')

  </div>

  {{-- ✅ FOLLOWERS MODAL (Alpine) --}}
  <div
    x-show="followersOpen"
    x-cloak
    x-transition.opacity
    class="fixed inset-0 z-[9999] flex items-start justify-center px-4"
    @keydown.escape.window="followersOpen=false"
  >
    <button type="button" class="absolute inset-0 bg-black/50" @click="followersOpen=false" aria-label="Close"></button>

    <div class="relative w-full max-w-[520px] mt-16 sm:mt-24 bg-app-card border border-app rounded-2xl shadow-app overflow-hidden">
      <div class="p-5 flex items-center justify-between border-b border-app">
        <div class="font-extrabold text-app">Followers</div>
        <button type="button" class="text-app-muted hover:text-app text-xl" @click="followersOpen=false" aria-label="Close">✕</button>
      </div>

      <div class="p-5 max-h-[70vh] overflow-y-auto space-y-3">
        @forelse(($followersRows ?? []) as $row)
          @php $f = $row->follower; @endphp
          @if($f)
            <a href="{{ route('profile.show', $f->user_id) }}"
               class="flex items-center justify-between gap-3 rounded-xl border border-app bg-app-input p-3 hover:opacity-95 transition">
              <div class="flex items-center gap-3 min-w-0">
                <img src="{{ asset($f->profile_pic ?? 'images/default.png') }}"
                     class="h-10 w-10 rounded-full object-cover border border-app"
                     alt="avatar">

                <div class="min-w-0">
                  <div class="text-sm font-semibold text-app truncate">{{ $f->first_name }} {{ $f->last_name }}</div>
                  <div class="text-xs text-app-muted truncate">{{ !empty($f->username) ? '@'.$f->username : 'No username' }}</div>
                </div>
              </div>
              <span class="text-xs text-app-muted">›</span>
            </a>
          @endif
        @empty
          <p class="text-sm text-app-muted">No followers yet.</p>
        @endforelse
      </div>
    </div>
  </div>

  {{-- ✅ FOLLOWING MODAL (Alpine) --}}
  <div
    x-show="followingOpen"
    x-cloak
    x-transition.opacity
    class="fixed inset-0 z-[9999] flex items-start justify-center px-4"
    @keydown.escape.window="followingOpen=false"
  >
    <button type="button" class="absolute inset-0 bg-black/50" @click="followingOpen=false" aria-label="Close"></button>

    <div class="relative w-full max-w-[520px] mt-16 sm:mt-24 bg-app-card border border-app rounded-2xl shadow-app overflow-hidden">
      <div class="p-5 flex items-center justify-between border-b border-app">
        <div class="font-extrabold text-app">Following</div>
        <button type="button" class="text-app-muted hover:text-app text-xl" @click="followingOpen=false" aria-label="Close">✕</button>
      </div>

      <div class="p-5 max-h-[70vh] overflow-y-auto space-y-3">
        @forelse(($followingRows ?? []) as $row)
          @php $t = $row->following; @endphp
          @if($t)
            <a href="{{ route('profile.show', $t->user_id) }}"
               class="flex items-center justify-between gap-3 rounded-xl border border-app bg-app-input p-3 hover:opacity-95 transition">
              <div class="flex items-center gap-3 min-w-0">
                <img src="{{ asset($t->profile_pic ?? 'images/default.png') }}"
                     class="h-10 w-10 rounded-full object-cover border border-app"
                     alt="avatar">

                <div class="min-w-0">
                  <div class="text-sm font-semibold text-app truncate">{{ $t->first_name }} {{ $t->last_name }}</div>
                  <div class="text-xs text-app-muted truncate">{{ !empty($t->username) ? '@'.$t->username : 'No username' }}</div>
                </div>
              </div>
              <span class="text-xs text-app-muted">›</span>
            </a>
          @endif
        @empty
          <p class="text-sm text-app-muted">Not following anyone yet.</p>
        @endforelse
      </div>
    </div>
  </div>

  {{-- ✅ EDIT PROFILE MODAL (Alpine wrapper, uses your partial markup inside) --}}
  @if($authId === $user->user_id)
    <div
      x-show="editProfileOpen"
      x-cloak
      x-transition.opacity
      class="fixed inset-0 z-[9999] flex items-center justify-center px-4"
      @keydown.escape.window="editProfileOpen=false"
    >
      <button type="button" class="absolute inset-0 bg-black/50" @click="editProfileOpen=false" aria-label="Close"></button>

      {{-- Keep your existing modal UI --}}
      <div class="relative w-full max-w-md">
        {{-- IMPORTANT: remove the old hidden wrapper behavior by keeping the partial content ONLY inside this container --}}
        <div class="bg-app-card border border-app rounded-2xl shadow-app overflow-hidden">
          <div class="px-6 py-5 border-b border-app flex items-center justify-between">
            <h2 class="text-lg font-extrabold text-app">Edit Profile</h2>
            <button type="button" class="h-8 w-8 rounded-xl hover-app grid place-items-center text-app-muted"
              @click="editProfileOpen=false" aria-label="Close">
              <span class="text-xl leading-none">×</span>
            </button>
          </div>

          <form action="{{ route('profile.update', $user->user_id) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <input type="hidden" name="source" value="profile">

            <div>
              <label class="block text-sm font-semibold text-app mb-2">First Name</label>
              <input type="text" name="first_name" value="{{ $user->first_name }}"
                class="w-full rounded-xl bg-app-input border border-app px-4 py-2 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)]" />
            </div>

            <div>
              <label class="block text-sm font-semibold text-app mb-2">Last Name</label>
              <input type="text" name="last_name" value="{{ $user->last_name }}"
                class="w-full rounded-xl bg-app-input border border-app px-4 py-2 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)]" />
            </div>

            <div>
              <label class="block text-sm font-semibold text-app mb-2">Bio</label>
              <textarea name="bio" rows="3"
                class="w-full rounded-xl bg-app-input border border-app px-4 py-2 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)]">{{ $user->bio }}</textarea>
            </div>

            <div>
              <label class="block text-sm font-semibold text-app mb-2">Profile Picture URL</label>
              <input type="text" name="profile_pic" value="{{ $user->profile_pic }}"
                class="w-full rounded-xl bg-app-input border border-app px-4 py-2 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)] placeholder:text-app-muted"
                placeholder="https:// or images/default.png" />
            </div>

            <div class="pt-2 flex items-center justify-end gap-3">
              <button type="button" class="rounded-xl btn-ghost px-5 py-2.5 text-sm font-semibold"
                @click="editProfileOpen=false">
                Cancel
              </button>

              <button type="submit"
                class="rounded-xl btn-brand px-5 py-2.5 text-sm font-semibold hover:opacity-95 active:opacity-90">
                Save Changes
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif

  {{-- Create/Edit Post Modal (needed for open-edit) --}}
  @include('partials.create-post-modal')

  {{-- Report Modal --}}
  @include('partials.create-report-modal')

</div>
@endsection
