{{-- resources/views/partials/create-post-modal.blade.php --}}
<div
    x-show="createOpen"
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
    <div class="relative w-full max-w-xl bg-app-card border border-app rounded-2xl shadow-app overflow-hidden">

        {{-- header --}}
        <div class="px-6 py-5 border-b border-app flex items-center justify-between gap-3">
            <div>
                <div class="text-lg font-extrabold text-app">Create Post</div>
                <div class="text-sm text-app-muted">Share something with the PUP community.</div>
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

        {{-- form --}}
        <form class="p-6 space-y-5" method="POST" action="#">
            @csrf

            {{-- audience --}}
            <div class="flex items-center justify-between">
                <div class="text-sm font-semibold text-app">Audience</div>
                <div class="inline-flex items-center gap-2 rounded-full bg-app-input border border-app px-3 py-1.5 text-xs font-semibold text-app">
                    🌐 Public
                </div>
            </div>

            {{-- content --}}
            <div>
                <label class="block text-sm font-semibold text-app mb-2">What’s on your mind?</label>
                <textarea
                    name="content"
                    rows="4"
                    class="w-full rounded-2xl bg-app-input border border-app px-4 py-3 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)] placeholder:text-app-muted"
                    placeholder="Write something..."></textarea>
                <div class="mt-2 text-xs text-app-muted">Tip: Keep it respectful and helpful.</div>
            </div>

            {{-- attachment --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-app mb-2">Photo URL (optional)</label>
                    <input
                        type="url"
                        name="image_url"
                        class="w-full rounded-xl bg-app-input border border-app px-4 py-3 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)] placeholder:text-app-muted"
                        placeholder="https://..." />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-app mb-2">Type</label>
                    <select
                        name="type"
                        class="w-full rounded-xl bg-app-input border border-app px-4 py-3 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)]">
                        <option value="post" selected>Post</option>
                        <option value="event">Event</option>
                        <option value="lost_found">Lost &amp; Found</option>
                    </select>
                </div>
            </div>

            {{-- footer buttons --}}
            <div class="pt-2 flex items-center justify-end gap-3">
                <button
                    type="button"
                    class="rounded-xl btn-ghost px-5 py-2.5 text-sm font-semibold"
                    @click="createOpen=false">
                    Cancel
                </button>

                <button
                    type="submit"
                    class="rounded-xl btn-brand px-5 py-2.5 text-sm font-semibold hover:opacity-95 active:opacity-90">
                    Post
                </button>
            </div>
        </form>

    </div>
</div>