{{-- resources/views/partials/right-sidebar.blade.php --}}
<aside class="bg-white border-l border-gray-200 lg:sticky lg:top-0 lg:h-screen overflow-y-auto">
    <div class="h-full flex flex-col px-4 sm:px-6 py-6">
        <div class="space-y-5">

            {{-- Trending --}}
            <div class="bg-white rounded-2xl shadow-[0_18px_40px_rgba(0,0,0,.10)] border border-gray-100 p-6">
                <div class="font-extrabold text-gray-900 mb-4 flex items-center gap-2">
                    <span>📌</span> Trending in PUP
                </div>

                <div class="space-y-4 text-sm">
                    <div>
                        <div class="text-xs text-gray-500">1 · Trending</div>
                        <div class="font-semibold">#IskolarNgBayan</div>
                        <div class="text-xs text-gray-500">1,234 posts</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">2 · Trending</div>
                        <div class="font-semibold">#PUPEnrollment2025</div>
                        <div class="text-xs text-gray-500">1,934 posts</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">3 · Trending</div>
                        <div class="font-semibold">#finalsweek</div>
                        <div class="text-xs text-gray-500">1,234 posts</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">4 · Trending</div>
                        <div class="font-semibold">#CCISWeek</div>
                        <div class="text-xs text-gray-500">2,234 posts</div>
                    </div>
                </div>
            </div>

            {{-- Who to follow --}}
            <div class="bg-white rounded-2xl shadow-[0_18px_40px_rgba(0,0,0,.10)] border border-gray-100 p-6">
                <div class="font-extrabold text-gray-900 mb-4">Who to follow</div>

                <div class="space-y-4">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-gray-200"></div>
                            <div class="leading-tight">
                                <div class="text-sm font-semibold text-gray-900">Juan Dela Cruz</div>
                                <div class="text-xs text-gray-500">@juanisko</div>
                            </div>
                        </div>
                        <button class="px-3 py-1.5 rounded-full bg-gray-100 text-sm font-semibold hover:bg-gray-200">
                            Follow
                        </button>
                </div>
                @endfor
            </div>

            <div class="mt-6 text-xs text-gray-500">
                © 2025 PUPCOM · Polytechnic University of the Philippines
            </div>
        </div>

    </div>

    <div class="flex-1"></div>
    </div>
</aside>