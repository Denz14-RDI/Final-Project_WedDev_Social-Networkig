{{-- resources/views/partials/right-sidebar.blade.php --}}

{{-- Right sidebar with highlights and who to follow --}}

<div x-data="{ rbOpen:false }">

    {{-- Floating button that opens the sidebar (for mobile only) --}}
    <button
        type="button"
        class="lg:hidden fixed bottom-4 right-4 z-40 h-12 w-12 rounded-2xl bg-app-brand text-white shadow-app grid place-items-center active:opacity-90"
        @click="rbOpen=true"
        aria-label="Open sidebar">
        ☰
    </button>

    {{-- Backdrop (for mobile only) --}}
    <div
        x-show="rbOpen"
        x-cloak
        class="fixed inset-0 bg-black/50 z-40 lg:hidden"
        @click="rbOpen=false"
        aria-hidden="true"></div>

    {{-- MOBILE: bottom sheet drawer --}}
    <aside
        x-show="rbOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-6"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-6"
        class="lg:hidden fixed inset-x-0 bottom-0 z-50 bg-app-card border-t border-app rounded-t-3xl shadow-app overflow-hidden"
        style="max-height: 85dvh;">
        {{-- Header --}}
        <div class="px-5 py-4 border-b border-app flex items-center justify-between">
            <div class="font-extrabold text-app">Sidebar</div>
            <button
                type="button"
                class="h-10 w-10 rounded-xl bg-app-input border border-app text-app grid place-items-center"
                @click="rbOpen=false"
                aria-label="Close sidebar">
                ✕
            </button>
        </div>

        {{-- Content area (scrollable) --}}
        <div class="p-4 overflow-y-auto" style="max-height: calc(85dvh - 64px);">
            <div class="space-y-5">

                {{-- Highlights of the Week --}}
                <div class="bg-app-card rounded-2xl shadow-app border border-app p-6">
                    <div class="font-extrabold text-app mb-1">
                        Highlights of the Week
                    </div>

                    <div class="text-xs text-app-muted mb-4">
                        Based on posts from the last 7 days
                    </div>

                    @php
                    $scope = request('scope');
                    $isExploreAll = ($scope === 'all') && empty($activeCategory ?? null);
                    @endphp

                    {{-- "All Categories" link clears category filter and shows everything (Explore all posts) --}}
                    <a href="{{ route('feed', ['scope' => 'all']) }}"
                        class="block mb-4 text-sm font-semibold {{ $isExploreAll ? 'text-app' : 'text-app-muted hover:text-app' }}">
                        📌 All Categories
                    </a>

                    <div class="space-y-3 text-sm">
                        @forelse(($highlights ?? collect()) as $i => $h)
                        @php
                        $isActive = ($scope === 'all') && (($activeCategory ?? null) === ($h['key'] ?? null));
                        @endphp

                    {{-- Clicking a category link filters the feed by that category --}}
                        <a href="{{ route('feed', ['category' => $h['key'], 'scope' => 'all']) }}"
                            class="block rounded-xl p-3 border border-app hover:bg-app-input transition {{ $isActive ? 'bg-app-input' : '' }}">

                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="text-xs text-app-muted">
                                        {{ $i + 1 }} · Top this week
                                    </div>

                                    <div class="font-semibold text-app truncate">
                                        {{ $h['label'] ?? '' }}
                                    </div>

                                    <div class="text-xs text-app-muted">
                                        {{ number_format($h['total'] ?? 0) }} posts
                                    </div>
                                </div>

                                @if($isActive)
                                <span class="text-xs px-2 py-1 rounded-full bg-app-page border border-app text-app-muted">
                                    Active
                                </span>
                                @endif
                            </div>
                        </a>
                        @empty
                        <p class="text-xs text-app-muted">No posts this week yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Who to follow --}}
                <div class="bg-app-card rounded-2xl shadow-app border border-app p-6">
                    <div class="font-extrabold text-app mb-4">Who to follow</div>

                    {{-- List of user suggestions --}}
                    <div class="space-y-4">
                        @php $suggestions = $whoToFollow ?? collect(); @endphp

                        @forelse($suggestions as $u)
                        @if($u->role === 'member')
                        @php
                        $isFollowing = ($followMap[$u->user_id] ?? null) === 'following';
                        $friendId = $followIdMap[$u->user_id] ?? null;
                        @endphp

                        {{-- profile picture with a default fallback --}}
                        <div class="flex items-center justify-between gap-4">
                            <a href="{{ route('profile.show', $u->user_id) }}"
                                class="flex items-center gap-3 min-w-0 group">
                                <img src="{{ asset(!empty($u->profile_pic) ? $u->profile_pic : 'images/default.png') }}"
                                    class="h-10 w-10 rounded-full object-cover border border-app"
                                    alt="avatar">

                                <div class="leading-tight min-w-0">
                                    <div class="text-sm font-semibold text-app truncate group-hover:underline">
                                        {{ $u->first_name }} {{ $u->last_name }}
                                    </div>

                                    <div class="text-xs text-app-muted truncate group-hover:underline">
                                        {{ !empty($u->username) ? '@'.$u->username : 'No username' }}
                                    </div>
                                </div>
                            </a>

                            {{-- If already following, show "Following" --}}
                            {{-- If not following yet, show Follow form --}}
                            <div class="shrink-0">
                                @if($isFollowing)
                                <button type="button"
                                    class="px-4 py-2 rounded-full border border-app text-app font-semibold bg-app-input opacity-70 cursor-not-allowed"
                                    disabled>
                                    Following
                                </button>
                                @else
                                <form action="{{ route('friends.store', $u->user_id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 rounded-full btn-ghost text-sm font-semibold">
                                        Follow
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endif
                        @empty
                        <p class="text-xs text-app-muted">No suggestions right now.</p>
                        @endforelse
                    </div>

                    <div class="mt-6 text-xs text-app-muted">
                        © 2025 PUPCOM · Polytechnic University of the Philippines
                    </div>
                </div>

            </div>
        </div>
    </aside>

    {{-- DESKTOP: original sidebar --}}
    <aside class="hidden lg:block bg-app-page lg:sticky lg:top-0 lg:h-screen overflow-y-auto">
        <div class="h-full flex flex-col px-5 sm:px-7 py-6">
            <div class="space-y-5">

                {{-- Highlights of the Week --}}
                <div class="bg-app-card rounded-2xl shadow-app border border-app p-6">
                    <div class="font-extrabold text-app mb-1">
                        Highlights of the Week
                    </div>

                    <div class="text-xs text-app-muted mb-4">
                        Based on posts from the last 7 days
                    </div>

                    @php
                    $scope = request('scope');
                    $isExploreAll = ($scope === 'all') && empty($activeCategory ?? null);
                    @endphp

                    {{-- "All Categories" link clears category filter and shows everything (Explore all posts) --}}
                    <a href="{{ route('feed', ['scope' => 'all']) }}"
                        class="block mb-4 text-sm font-semibold {{ $isExploreAll ? 'text-app' : 'text-app-muted hover:text-app' }}">
                        📌 All Categories
                    </a>

                    <div class="space-y-3 text-sm">
                        @forelse(($highlights ?? collect()) as $i => $h)
                        @php
                        $isActive = ($scope === 'all') && (($activeCategory ?? null) === ($h['key'] ?? null));
                        @endphp

                        {{-- Clicking a category link filters the feed by that category --}}
                        <a href="{{ route('feed', ['category' => $h['key'], 'scope' => 'all']) }}"
                            class="block rounded-xl p-3 border border-app hover:bg-app-input transition {{ $isActive ? 'bg-app-input' : '' }}">

                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="text-xs text-app-muted">
                                        {{ $i + 1 }} · Top this week
                                    </div>

                                    <div class="font-semibold text-app truncate">
                                        {{ $h['label'] ?? '' }}
                                    </div>

                                    <div class="text-xs text-app-muted">
                                        {{ number_format($h['total'] ?? 0) }} posts
                                    </div>
                                </div>

                                @if($isActive)
                                <span class="text-xs px-2 py-1 rounded-full bg-app-page border border-app text-app-muted">
                                    Active
                                </span>
                                @endif
                            </div>
                        </a>
                        @empty
                        <p class="text-xs text-app-muted">No posts this week yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Who to follow --}}
                <div class="bg-app-card rounded-2xl shadow-app border border-app p-6">
                    <div class="font-extrabold text-app mb-4">Who to follow</div>

                    {{-- List of user suggestions --}}
                    <div class="space-y-4">
                        @php $suggestions = $whoToFollow ?? collect(); @endphp

                        @forelse($suggestions as $u)
                        @if($u->role === 'member')
                        @php
                        $isFollowing = ($followMap[$u->user_id] ?? null) === 'following';
                        $friendId = $followIdMap[$u->user_id] ?? null;
                        @endphp

                        <div class="flex items-center justify-between gap-4">
                            <a href="{{ route('profile.show', $u->user_id) }}"
                                class="flex items-center gap-3 min-w-0 group">
                                <img src="{{ asset(!empty($u->profile_pic) ? $u->profile_pic : 'images/default.png') }}"
                                    class="h-10 w-10 rounded-full object-cover border border-app"
                                    alt="avatar">

                                <div class="leading-tight min-w-0">
                                    <div class="text-sm font-semibold text-app truncate group-hover:underline">
                                        {{ $u->first_name }} {{ $u->last_name }}
                                    </div>

                                    <div class="text-xs text-app-muted truncate group-hover:underline">
                                        {{ !empty($u->username) ? '@'.$u->username : 'No username' }}
                                    </div>
                                </div>
                            </a>

                            {{-- If already following, show "Following" --}}
                            {{-- If not following yet, show Follow form --}}
                            <div class="shrink-0">
                                @if($isFollowing)
                                <button type="button"
                                    class="px-4 py-2 rounded-full border border-app text-app font-semibold bg-app-input opacity-70 cursor-not-allowed"
                                    disabled>
                                    Following
                                </button>
                                @else
                                <form action="{{ route('friends.store', $u->user_id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 rounded-full btn-ghost text-sm font-semibold">
                                        Follow
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @endif
                        @empty
                        <p class="text-xs text-app-muted">No suggestions right now.</p>
                        @endforelse
                    </div>

                    <div class="mt-6 text-xs text-app-muted">
                        © 2025 PUPCOM · Polytechnic University of the Philippines
                    </div>
                </div>

            </div>
        </div>
    </aside>

</div>