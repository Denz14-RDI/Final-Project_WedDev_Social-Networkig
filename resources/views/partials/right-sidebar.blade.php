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

                {{-- All / Clear filter (pin only) --}}
                <a href="{{ route('feed') }}"
                   class="block mb-4 text-sm font-semibold {{ empty($activeCategory ?? null) ? 'text-app' : 'text-app-muted hover:text-app' }}">
                    📌 All Categories
                </a>

                <div class="space-y-3 text-sm">
                    @forelse(($highlights ?? collect()) as $i => $h)
                        @php
                            $isActive = ($activeCategory ?? null) === ($h['key'] ?? null);
                        @endphp

                        <a href="{{ route('feed', ['category' => $h['key']]) }}"
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
                    @forelse(($whoToFollow ?? collect()) as $u)
                        @php
                            $isFollowing = ($followMap[$u->user_id] ?? null) === 'following';
                            $friendId = $followIdMap[$u->user_id] ?? null; // ✅ needed for unfollow
                        @endphp

                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 min-w-0">
                                <img
                                    src="{{ asset(!empty($u->profile_pic) ? $u->profile_pic : 'images/default.png') }}"
                                    class="h-10 w-10 rounded-full object-cover border border-app"
                                    alt="avatar">

                                <div class="leading-tight min-w-0">
                                    <div class="text-sm font-semibold text-app truncate">
                                        {{ $u->first_name }} {{ $u->last_name }}
                                    </div>

                                    <div class="text-xs text-app-muted truncate">
                                        @if(!empty($u->username))
                                            {{ '@' . $u->username }}
                                        @else
                                            <span class="italic">No username</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Button (toggle) --}}
                            <div class="shrink-0">
                                @if($isFollowing && $friendId)
                                    {{-- Click "Following" => Unfollow --}}
                                    <form action="{{ route('friends.unfollow', $friendId) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 rounded-full border border-gray-300 text-gray-200 font-semibold bg-transparent hover:bg-white/10 transition">
                                            Following
                                        </button>
                                    </form>
                                @else
                                    {{-- Click "Follow" => Follow --}}
                                    <form action="{{ route('friends.store', $u) }}" method="POST">
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

        </div>
    </div>
</aside>
