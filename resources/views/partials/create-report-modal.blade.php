{{-- resources/views/partials/report-modal.blade.php --}}

{{-- Modal for reporting a post --}}

{{-- Breakdown by sections --}}
<div x-show="reportOpen"
     x-transition.opacity
     class="fixed inset-0 z-[999] flex items-center justify-center px-4"
     style="display:none;"
     @keydown.escape.window="reportOpen=false">

    {{-- Backdrop --}}
    <button type="button"
            class="absolute inset-0 bg-black/50"
            @click="reportOpen=false"
            aria-label="Close modal"></button>

    {{-- Modal --}}
    <div class="relative w-full max-w-md bg-app-card border border-app rounded-2xl shadow-app overflow-hidden">

        {{-- Header with title and close button --}}
        <div class="px-6 py-5 border-b border-app flex items-center justify-between gap-3">
            <div>
                <div class="text-lg font-extrabold text-app">Report Post</div>
                <div class="text-sm text-app-muted">Help us keep the community safe.</div>
            </div>
            <button type="button"
                    class="h-10 w-10 rounded-xl hover-app grid place-items-center text-app-muted"
                    title="Close"
                    @click="reportOpen=false">
                <span class="text-xl leading-none">×</span>
            </button>
        </div>

        {{-- Form with fields for reason and details --}}
        <form class="p-6 space-y-5"
              method="POST"
              :action="'/posts/' + reportPost.post_id + '/report'">
            @csrf

            {{-- reason --}}
            <div>
                <label class="block text-sm font-semibold text-app mb-2">Reason</label>
                <select name="reason"
                        class="w-full rounded-xl bg-app-input border border-app px-4 py-3 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)]"
                        required>
                    <option value="spam">Spam</option>
                    <option value="harassment">Harassment</option>
                    <option value="misinformation">Misinformation</option>
                    <option value="inappropriate">Inappropriate</option>
                    <option value="other">Other</option>
                </select>
            </div>

            {{-- details --}}
            <div>
                <label class="block text-sm font-semibold text-app mb-2">Details (optional)</label>
                <textarea name="details"
                          rows="3"
                          class="w-full rounded-xl bg-app-input border border-app px-4 py-3 text-sm text-app outline-none focus:ring-2 focus:ring-[var(--brand)] placeholder:text-app-muted"
                          placeholder="Add more context..."></textarea>
            </div>

            {{-- Footer buttons for cancel and submit --}}
            <div class="pt-2 flex items-center justify-end gap-3">
                <button type="button"
                        class="rounded-xl btn-ghost px-5 py-2.5 text-sm font-semibold"
                        @click="reportOpen=false">
                    Cancel
                </button>

                <button type="submit"
                        class="rounded-xl btn-brand px-5 py-2.5 text-sm font-semibold hover:opacity-95 active:opacity-90">
                    Submit Report
                </button>
            </div>
        </form>
    </div>
</div>