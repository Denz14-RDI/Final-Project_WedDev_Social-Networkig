{{-- A page that lists your notifications (likes/comments/follows) and lets you mark them as read --}}

@extends('layouts.app')
@section('title','Notifications')

@section('main_class', 'bg-app-page')

@section('content')

{{-- Alpine component (notifPage) controls read/unread logic --}}
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

    {{-- CENTER SECTION (scrollable) --}}
    <section class="px-4 sm:px-6 lg:px-10 py-8 overflow-y-auto">
      <div class="w-full max-w-[840px] mx-auto space-y-5">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-4">
          <div>
            <div class="text-3xl font-extrabold text-app leading-tight">Notifications</div>
            <div class="text-sm text-app-muted">Recent activity</div>
          </div>

          {{-- Mark all as read button --}}
          <button
            type="button"
            class="text-sm font-semibold text-app hover:underline underline-offset-4 disabled:opacity-60"
            :disabled="unreadCount === 0"
            @click="markAll()"
          >
            Mark all as read
          </button>
        </div>

        {{-- Notification list --}}
        <div class="space-y-4">
          @forelse($notifications as $n)
            @php
              $data = $n->notif_data ?? [];
              // Name of the actor (user who performed the action)
              $actorName = $data['actor_name'] ?? 'Someone';

              // Default message and destination link
              $message = '';
              $href = route('feed');

              // Customize message and link based on notification type
              // Like, Comment, and Follow notifications
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

            {{-- Clickable notification item --}}
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

                  {{-- Message and timestamp --}}
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

                  {{-- Unread indicator --}}
                  <template x-if="!readMap[{{ $n->notif_id }}]">
                    <div class="h-2.5 w-2.5 rounded-full bg-app-brand"></div>
                  </template>

                </div>
              </div>
            </a>

          {{-- If no notifications --}}
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

{{-- JavaScript for page interaction --}}
<script>
function notifPage({ markUrlBase, unreadUrl, markAllUrl, csrf, initialUnread }) {
  return {
    // Unread count shown/used for disabling "mark all" button
    unreadCount: initialUnread,
    readMap: {},

    // Sends an event to update sidebar count
    syncSidebarCount(count){
      window.dispatchEvent(new CustomEvent('notif-updated', { detail: { count } }));
    },

    // This is called when a notification is clicked
    async openNotif(e, notifId, href, alreadyRead){
      // Mark as read if not already read
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

          // Update UI: mark as read and decrement count
          this.readMap[notifId] = true;
          this.unreadCount = data.count ?? Math.max(0, this.unreadCount - 1);

          // Update sidebar count
          this.syncSidebarCount(this.unreadCount);
        }
      }

      // Redirect to the notification link
      window.location.href = href;
    },

    // Marks all notifications as read
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

      // Set unread count to 0
      this.unreadCount = data.count ?? 0;

      // Mark all local read states to true
      Object.keys(this.readMap).forEach(k => this.readMap[k] = true);

      // Update sidebar count
      this.syncSidebarCount(this.unreadCount);
    },
  }
}
</script>
@endsection