{{-- resources/views/partials/profile-followers-modal.blade.php --}}
<div id="followersModal" class="fixed inset-0 hidden z-[9999]">
  <div id="closeFollowersBackdrop" class="absolute inset-0 bg-black/50"></div>

  <div class="relative mx-auto mt-24 w-[92%] max-w-[520px] bg-app-card border border-app rounded-2xl shadow-app overflow-hidden">
    <div class="p-5 flex items-center justify-between border-b border-app">
      <div class="font-extrabold text-app">Followers</div>
      <button type="button" id="closeFollowersX" class="text-app-muted hover:text-app text-xl">✕</button>
    </div>

    <div class="p-5 max-h-[60vh] overflow-y-auto space-y-3">
      @forelse(($followersRows ?? []) as $row)
        @php $f = $row->follower; @endphp

        @if($f)
          <a href="{{ route('profile.show', $f->user_id) }}"
             class="flex items-center justify-between gap-3 rounded-xl border border-app bg-app-input p-3 hover:opacity-95 transition">
            <div class="flex items-center gap-3 min-w-0">
              <img
                src="{{ asset($f->profile_pic ?? 'images/default.png') }}"
                class="h-10 w-10 rounded-full object-cover border border-app"
                alt="avatar">

              <div class="min-w-0">
                <div class="text-sm font-semibold text-app truncate">
                  {{ $f->first_name }} {{ $f->last_name }}
                </div>
                <div class="text-xs text-app-muted truncate">
                  {{ !empty($f->username) ? '@'.$f->username : 'No username' }}
                </div>
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
