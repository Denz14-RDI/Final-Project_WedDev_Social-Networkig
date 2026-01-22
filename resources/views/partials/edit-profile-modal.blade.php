<div id="editProfileModal"
  class="hidden fixed inset-0 z-[999] flex items-center justify-center px-4">

  {{-- backdrop --}}
  <button id="closeEditProfileBackdrop"
    type="button"
    class="absolute inset-0 bg-black/50"
    aria-label="Close"></button>

  {{-- modal --}}
  <div class="relative w-full max-w-md bg-app-card border border-app rounded-2xl shadow-app overflow-hidden flex flex-col">

    {{-- header --}}
    <div class="px-6 py-5 border-b border-app flex items-center justify-between">
      <h2 class="text-lg font-extrabold text-app">Edit Profile</h2>

      <button id="closeEditProfileX"
        type="button"
        class="h-8 w-8 rounded-xl hover-app grid place-items-center text-app-muted"
        title="Close">
        <span class="text-xl leading-none">×</span>
      </button>
    </div>

    {{-- form --}}
    <form action="{{ route('profile.update', $user->user_id) }}"
      method="POST"
      class="p-6 space-y-5">
      @csrf
      @method('PUT')

      <input type="hidden" name="source" value="profile">

      {{-- First Name --}}
      <div>
        <label class="block text-sm font-semibold text-app mb-2">First Name</label>
        <input type="text" name="first_name" value="{{ $user->first_name }}"
          class="w-full rounded-xl bg-app-input border border-app px-4 py-2 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)]" />
      </div>

      {{-- Last Name --}}
      <div>
        <label class="block text-sm font-semibold text-app mb-2">Last Name</label>
        <input type="text" name="last_name" value="{{ $user->last_name }}"
          class="w-full rounded-xl bg-app-input border border-app px-4 py-2 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)]" />
      </div>

      {{-- Bio --}}
      <div>
        <label class="block text-sm font-semibold text-app mb-2">Bio</label>
        <textarea name="bio" rows="3"
          class="w-full rounded-xl bg-app-input border border-app px-4 py-2 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)]">{{ $user->bio }}</textarea>
      </div>

      {{-- Profile Picture URL --}}
      <div>
        <label class="block text-sm font-semibold text-app mb-2">Profile Picture URL</label>
        <input type="text" name="profile_pic" value="{{ $user->profile_pic }}"
          class="w-full rounded-xl bg-app-input border border-app px-4 py-2 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)] placeholder:text-app-muted"
          placeholder="https:// or images/default.png" />
      </div>

      {{-- footer buttons --}}
      <div class="pt-2 flex items-center justify-end gap-3">
        <button id="closeEditProfileBtn"
          type="button"
          class="rounded-xl btn-ghost px-5 py-2.5 text-sm font-semibold">
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
