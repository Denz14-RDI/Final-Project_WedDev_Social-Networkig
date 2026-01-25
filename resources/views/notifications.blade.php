@extends('layouts.app')
@section('title','Notifications')

@section('main_class', 'bg-app-page')

@section('content')
<div
  class="h-screen overflow-hidden"
  x-data="notifPage({
    markUrlBase: '{{ url('/notifications') }}',
    unreadUrl: '{{ route('notifications.unread') }}',
    markAllUrl: '{{ route('notifications.markAllAsRead') }}',
    csrf: '{{ csrf_token() }}',
    initialUnread: {{ $unreadCount ?? 0 }},
  })"
  x-init="syncSidebarCount(initialUnread)"
>
  <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] h-full">

    {{-- CENTER (scroll) --}}
    <section class="px-4 sm:px-6 lg:px-10 py-8 overflow-y-auto">
      <div class="w-full max-w-[840px] mx-auto space-y-5">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-4">
          <div>
            <div class="text-3xl font-extrabold text-app leading-tight">Notifications</div>
            <div class="text-sm text-app-muted">Recent activity</div>
          </div>

          <button
            type="button"
            class="text-sm font-semibold text-app hover:underline underline-offset-4 disabled:opacity-60"
            :disabled="unreadCount === 0"
            @click="markAll()"
          >
            Mark all as read
          </button>
        </div>

        {{-- List --}}
        <div class="space-y-4">
          @forelse($notifications as $n)
            @php
              $data = $n->notif_data ?? [];
              $actorName = $data['actor_name'] ?? 'Someone';

              // default message + link target
              $message = '';
              $href = route('feed');

              if ($n->notif_type === 'new_like') {
                $message = "<span class='font-semibold'>{$actorName}</span> liked your post.";
                $postId = $data['post_id'] ?? $n->entity_id;
                $href = route('posts.show', $postId);
              } elseif ($n->notif_type === 'new_comment') {
                $commentText = $data['comment_text'] ?? 'commented on your post';
                $safeText = e($commentText);
                $message = "<span class='font-semibold'>{$actorName}</span> commented on your post: “{$safeText}”";
                $postId = $data['post_id'] ?? $n->entity_id;
                $href = route('posts.show', $postId);
              } elseif ($n->notif_type === 'new_friend') {
                $message = "<span class='font-semibold'>{$actorName}</span> followed you.";
                $actorId = $data['actor_id'] ?? $n->entity_id;
                $href = route('profile.show', $actorId);
              }
            @endphp

            <a
              href="{{ $href }}"
              class="block bg-app-card rounded-2xl border border-app shadow-app overflow-hidden"
              data-notif-id="{{ $n->notif_id }}"
              @click.prevent="openNotif($event, {{ $n->notif_id }}, '{{ $href }}', {{ $n->read_at ? 'true' : 'false' }})"
            >
              <div
                class="p-5"
                :class="readMap[{{ $n->notif_id }}] ? '' : 'bg-[var(--amber-bg)]'"
                x-init="readMap[{{ $n->notif_id }}] = {{ $n->read_at ? 'true' : 'false' }}"
              >
                <div class="flex items-center gap-4">

                  <div class="h-12 w-12 rounded-full bg-app-input border border-app flex items-center justify-center font-bold text-app">
                    {{ strtoupper(mb_substr(($data['actor_name'] ?? 'N'), 0, 1)) }}
                  </div>

                  <div class="flex-1 min-w-0">
                    <div class="text-sm text-app">
                      {!! $message !!}
                    </div>
                    <div class="text-xs text-app-muted mt-1">
                      {{-- Exact timestamp + "time ago" --}}
                      {{ optional($n->created_at)->timezone(config('app.timezone'))->format('M d, Y h:i A') }}
                      &nbsp;|&nbsp;
                      {{ optional($n->created_at)->diffForHumans() }}
                    </div>
                  </div>

                  <template x-if="!readMap[{{ $n->notif_id }}]">
                    <div class="h-2.5 w-2.5 rounded-full bg-app-brand"></div>
                  </template>

                </div>
              </div>
            </a>

          @empty
            <p class="text-center text-app-muted">No notifications yet.</p>
          @endforelse
        </div>

      </div>
    </section>

    {{-- RIGHT SIDEBAR --}}
    @include('partials.right-sidebar')

  </div>
</div>

<script>
function notifPage({ markUrlBase, unreadUrl, markAllUrl, csrf, initialUnread }) {
  return {
    unreadCount: initialUnread,
    readMap: {},

    syncSidebarCount(count){
      window.dispatchEvent(new CustomEvent('notif-updated', { detail: { count } }));
    },

    async openNotif(e, notifId, href, alreadyRead){
      if (!alreadyRead && !this.readMap[notifId]) {
        const res = await fetch(`${markUrlBase}/${notifId}/read`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json',
          }
        });

        if (res.ok) {
          const data = await res.json();
          this.readMap[notifId] = true;
          this.unreadCount = data.count ?? Math.max(0, this.unreadCount - 1);
          this.syncSidebarCount(this.unreadCount);
        }
      }

      window.location.href = href;
    },

    async markAll(){
      const res = await fetch(markAllUrl, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrf,
          'Accept': 'application/json',
        }
      });

      if (!res.ok) return;

      const data = await res.json();
      this.unreadCount = data.count ?? 0;

      Object.keys(this.readMap).forEach(k => this.readMap[k] = true);

      this.syncSidebarCount(this.unreadCount);
    },
  }
}
</script>
@endsection