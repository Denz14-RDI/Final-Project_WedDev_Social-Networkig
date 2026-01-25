<div x-show="reportOpen"
    x-cloak
    x-transition.opacity
    class="fixed inset-0 z-[999] flex items-center justify-center px-4"
    style="display:none;"
    @keydown.escape.window="reportOpen=false">

    <button type="button"
        class="absolute inset-0 bg-black/50"
        @click="reportOpen=false"
        aria-label="Close modal"></button>

    <div class="relative w-full max-w-md bg-app-card border border-app rounded-2xl shadow-app overflow-hidden flex flex-col max-h-[90dvh]">

        <div class="px-6 py-5 border-b border-app flex items-center justify-between gap-3 shrink-0">
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

        <form class="p-6 space-y-5 overflow-y-auto"
            method="POST"
            :action="'/posts/' + reportPost.post_id + '/report'">
            @csrf
            ...
        </form>
    </div>
</div>