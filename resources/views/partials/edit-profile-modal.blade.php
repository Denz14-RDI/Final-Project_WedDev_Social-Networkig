<div id="editProfileModal" class="fixed inset-0 z-[999] hidden items-center justify-center px-4">
  {{-- Backdrop --}}
  <button type="button" id="closeEditProfileBackdrop" class="absolute inset-0 bg-black/50"></button>

  {{-- Modal card --}}
  <div class="relative w-full max-w-lg rounded-2xl bg-app-card shadow-app border border-app overflow-hidden">
    <div class="px-6 py-5 border-b border-app flex items-start justify-between gap-4">
      <div>
        <div class="text-lg font-extrabold text-app">Edit Profile</div>
        <div class="text-sm text-app-muted">Make changes to your profile information.</div>
      </div>
      <button type="button" id="closeEditProfileX" class="h-9 w-9 rounded-xl hover-app text-app-muted grid place-items-center">
        <span class="text-xl leading-none">×</span>
      </button>
    </div>

    {{-- ✅ This is where your form starts --}}
    <form action="{{ route('profile.update', $user->user_id) }}" method="POST" class="p-6 space-y-5">
      @csrf
      @method('PUT')

      {{-- Avatar field --}}
      <div>
        <label class="block text-sm font-semibold text-app mb-2">Avatar URL</label>
        <input type="text" name="profile_pic" value="{{ $user->profile_pic }}"
               class="w-full rounded-xl bg-app-input px-4 py-3 text-sm text-app border border-app outline-none focus:ring-2 focus:ring-[var(--brand)]" />
      </div>

      {{-- First Name --}}
      <div>
        <label class="block text-sm font-semibold text-app mb-2">First Name</label>
        <input type="text" name="first_name" value="{{ $user->first_name }}"
               class="w-full rounded-xl bg-app-input px-4 py-3 text-sm text-app border border-app outline-none focus:ring-2 focus:ring-[var(--brand)]" />
      </div>

      {{-- Last Name --}}
      <div>
        <label class="block text-sm font-semibold text-app mb-2">Last Name</label>
        <input type="text" name="last_name" value="{{ $user->last_name }}"
               class="w-full rounded-xl bg-app-input px-4 py-3 text-sm text-app border border-app outline-none focus:ring-2 focus:ring-[var(--brand)]" />
      </div>

      {{-- Bio --}}
      <div>
        <label class="block text-sm font-semibold text-app mb-2">Bio</label>
        <textarea name="bio" rows="3" maxlength="160"
                  class="w-full rounded-xl bg-app-input px-4 py-3 text-sm text-app border border-app outline-none focus:ring-2 focus:ring-[var(--brand)]">{{ $user->bio }}</textarea>
      </div>

      {{-- Buttons --}}
      <div class="pt-2 flex items-center justify-end gap-3">
        <button type="button" id="closeEditProfileBtn" class="rounded-xl btn-ghost px-5 py-2.5 text-sm font-semibold">Cancel</button>
        <button type="submit" class="rounded-xl btn-brand px-5 py-2.5 text-sm font-semibold hover:opacity-95 active:opacity-90">Save Changes</button>
      </div>
    </form>
  </div>
</div>