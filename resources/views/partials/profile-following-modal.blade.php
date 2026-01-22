{{-- resources/views/partials/profile-following-modal.blade.php --}}
<div id="followingModal" class="fixed inset-0 hidden z-[9999]">
  <div id="closeFollowingBackdrop" class="absolute inset-0 bg-black/50"></div>

  <div class="relative mx-auto mt-24 w-[92%] max-w-[520px] bg-app-card border border-app rounded-2xl shadow-app overflow-hidden">
    <div class="p-5 flex items-center justify-between border-b border-app">
      <div class="font-extrabold text-app">Following</div>
      <button type="button" id="closeFollowingX" class="text-app-muted hover:text-app text-xl">✕</button>
    </div>

    <div class="p-5 max-h-[60vh] overflow-y-auto space-y-3">
      @forelse(($followingRows ?? []) as $row)
        @php $t = $row->following; @endphp

        @if($t)
          <a href="{{ route('profile.show', $t->user_id) }}"
             class="flex items-center justify-between gap-3 rounded-xl border border-app bg-app-input p-3 hover:opacity-95 transition">
            <div class="flex items-center gap-3 min-w-0">
              <img
                src="{{ asset($t->profile_pic ?? 'images/default.png') }}"
                class="h-10 w-10 rounded-full object-cover border border-app"
                alt="avatar">

              <div class="min-w-0">
                <div class="text-sm font-semibold text-app truncate">
                  {{ $t->first_name }} {{ $t->last_name }}
                </div>
                <div class="text-xs text-app-muted truncate">
                  {{ !empty($t->username) ? '@'.$t->username : 'No username' }}
                </div>
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
