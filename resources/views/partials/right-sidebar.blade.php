{{-- resources/views/partials/right-sidebar.blade.php --}}
<aside class="bg-app-page lg:sticky lg:top-0 lg:h-screen overflow-y-auto">
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

                {{-- All / Clear filter (Explore all posts) --}}
                <a href="{{ route('feed', ['scope' => 'all']) }}"
                    class="block mb-4 text-sm font-semibold {{ $isExploreAll ? 'text-app' : 'text-app-muted hover:text-app' }}">
                    📌 All Categories
                </a>

                <div class="space-y-3 text-sm">
                    @forelse(($highlights ?? collect()) as $i => $h)
                    @php
                    $isActive = ($scope === 'all') && (($activeCategory ?? null) === ($h['key'] ?? null));
                    @endphp

                    <a href="{{ route('feed', ['category' => $h['key'], 'scope' => 'all']) }}"
                        class="block rounded-xl p-3 border border-app hover:bg-app-input transition
                                  {{ $isActive ? 'bg-app-input' : '' }}">

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

                <div class="space-y-4">
                    @php $suggestions = $whoToFollow ?? collect(); @endphp

                    @forelse($suggestions as $u)
                    @php
                    $isFollowing = ($followMap[$u->user_id] ?? null) === 'following'; // ✅ lowercase
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
                    @empty
                    <p class="text-xs text-app-muted">No suggestions right now.</p>
                    @endforelse
                </div>

                <div class="mt-6 text-xs text-app-muted">
                    © 2025 PUPCOM · Polytechnic University of the Philippines
                </div>
            </div>