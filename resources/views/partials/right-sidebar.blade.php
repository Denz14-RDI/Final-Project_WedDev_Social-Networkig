{{-- resources/views/partials/right-sidebar.blade.php --}}
<aside class="bg-app-page lg:sticky lg:top-0 lg:h-screen overflow-y-auto">
    <div class="h-full flex flex-col px-5 sm:px-7 py-6">
        <div class="space-y-5">

            {{-- Trending --}}
            <div class="bg-app-card rounded-2xl shadow-app border border-app p-6">
                <div class="font-extrabold text-app mb-4 flex items-center gap-2">
                    <span>📌</span>
                    <span>Trending in PUP</span>
                </div>

                <div class="space-y-4 text-sm">
                    <div>
                        <div class="text-xs text-app-muted">1 · Trending</div>
                        <div class="font-semibold text-app">#IskolarNgBayan</div>
                        <div class="text-xs text-app-muted">1,234 posts</div>
                    </div>

                    <div>
                        <div class="text-xs text-app-muted">2 · Trending</div>
                        <div class="font-semibold text-app">#PUPEnrollment2025</div>
                        <div class="text-xs text-app-muted">1,934 posts</div>
                    </div>

                    <div>
                        <div class="text-xs text-app-muted">3 · Trending</div>
                        <div class="font-semibold text-app">#finalsweek</div>
                        <div class="text-xs text-app-muted">1,234 posts</div>
                    </div>

                    <div>
                        <div class="text-xs text-app-muted">4 · Trending</div>
                        <div class="font-semibold text-app">#CCISWeek</div>
                        <div class="text-xs text-app-muted">2,234 posts</div>
                    </div>
                </div>
            </div>

            {{-- Who to follow --}}
            @php
            $whoToFollow = [
            ['name' => 'Juan Dela Cruz', 'handle' => '@juanisko', 'avatar' => 'https://i.pravatar.cc/120?img=11'],
            ['name' => 'Anne Garcia', 'handle' => '@annegarcia', 'avatar' => 'https://i.pravatar.cc/120?img=47'],
            ['name' => 'PUP Tech Club', 'handle' => '@puptechclub', 'avatar' => 'https://i.pravatar.cc/120?img=15'],
            ['name' => 'Prof. Maria Santos', 'handle' => '@mariasantos', 'avatar' => 'https://i.pravatar.cc/120?img=49'],
            ];
            @endphp

            <div class="bg-app-card rounded-2xl shadow-app border border-app p-6">
                <div class="font-extrabold text-app mb-4">Who to follow</div>

                <div class="space-y-4">
                    @foreach($whoToFollow as $u)
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <img
                                src="{{ $u['avatar'] }}"
                                class="h-10 w-10 rounded-full object-cover border border-app"
                                alt="avatar">
                            <div class="leading-tight min-w-0">
                                <div class="text-sm font-semibold text-app truncate">{{ $u['name'] }}</div>
                                <div class="text-xs text-app-muted truncate">{{ $u['handle'] }}</div>
                            </div>
                        </div>

                        <button type="button" class="shrink-0 px-4 py-2 rounded-full btn-ghost text-sm font-semibold">
                            Follow
                        </button>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 text-xs text-app-muted">
                    © 2025 PUPCOM · Polytechnic University of the Philippines
                </div>
            </div>

        </div>
    </div>
</aside>