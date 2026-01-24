{{-- resources/views/partials/create-post-modal.blade.php --}}

<div
  x-show="createOpen"
  x-cloak
  x-transition.opacity
  class="fixed inset-0 z-[999] flex items-center justify-center px-4"
  style="display:none;"
  @keydown.escape.window="createOpen=false">
  {{-- backdrop --}}
  <button
    type="button"
    class="absolute inset-0 bg-black/50"
    @click="createOpen=false"
    aria-label="Close modal"></button>

  {{-- modal --}}
  <div class="relative w-full max-w-xl bg-app-card border border-app rounded-2xl shadow-app overflow-hidden flex flex-col max-h-[90dvh]">

    {{-- header --}}
    <div class="px-6 py-5 border-b border-app flex items-center justify-between gap-3 shrink-0">
      <div>
        <div class="text-lg font-extrabold text-app" x-text="editMode ? 'Edit Post' : 'Create Post'"></div>
        <div class="text-sm text-app-muted" x-text="editMode ? 'Update your post details.' : 'Share something with the PUP community.'"></div>
      </div>

      {{-- close --}}
      <button
        type="button"
        class="h-10 w-10 rounded-xl hover-app grid place-items-center text-app-muted"
        title="Close"
        @click="createOpen=false">
        <span class="text-xl leading-none">×</span>
      </button>
    </div>

    {{-- form (scrolls on small screens) --}}
    <form class="p-6 space-y-5 overflow-y-auto"
      method="POST"
      :action="editMode ? '{{ url('/posts') }}/' + editPost.post_id : '{{ route('posts.store') }}'">

      @csrf

      <template x-if="editMode">
        <input type="hidden" name="_method" value="PUT">
      </template>

      <div>
        <label class="block text-sm font-semibold text-app mb-2">What’s on your mind?</label>
        <textarea
          name="post_content"
          rows="4"
          x-model="editPost.post_content"
          class="w-full rounded-2xl bg-app-input border border-app px-4 py-3 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)] placeholder:text-app-muted"
          placeholder="Write something..."
          required></textarea>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-semibold text-app mb-2">Photo URL (optional)</label>
          <input
            type="url"
            name="image"
            x-model="editPost.image"
            class="w-full rounded-xl bg-app-input border border-app px-4 py-3 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)] placeholder:text-app-muted"
            placeholder="https://..." />
        </div>

        <div>
          <label class="block text-sm font-semibold text-app mb-2">Category</label>
          <select
            name="category"
            x-model="editPost.category"
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

      <div class="pt-2 flex items-center justify-end gap-3">
        <button
          type="button"
          class="rounded-xl btn-ghost px-5 py-2.5 text-sm font-semibold"
          @click="createOpen=false">
          Cancel
        </button>

        <button
          type="submit"
          class="rounded-xl btn-brand px-5 py-2.5 text-sm font-semibold hover:opacity-95 active:opacity-90"
          x-text="editMode ? 'Update' : 'Post'"></button>
      </div>
    </form>

  </div>
</div>