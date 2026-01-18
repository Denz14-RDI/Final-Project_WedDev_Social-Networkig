{{-- resources/views/partials/right-sidebar.blade.php --}}
<aside class="bg-app-page lg:sticky lg:top-0 lg:h-screen overflow-y-auto">
    <div class="h-full flex flex-col px-5 sm:px-7 py-6">
        <div class="space-y-5">

            {{-- Trending --}}
            <div class="bg-app-card rounded-2xl shadow-[0_18px_40px_rgba(0,0,0,.08)] border border-app p-6">
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
            $currentUser = auth()->user();
            $whoToFollow = \App\Models\User::where('user_id', '!=', $currentUser->user_id)
                ->inRandomOrder()
                ->limit(4)
                ->get();
            @endphp

            <div class="bg-app-card rounded-2xl shadow-[0_18px_40px_rgba(0,0,0,.08)] border border-app p-6">
                <div class="font-extrabold text-app mb-4">Who to follow</div>

                <div class="space-y-4">
                    @foreach($whoToFollow as $u)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img
                                src="{{ $u->profile_pic ?? 'https://i.pravatar.cc/120?img=' . $u->user_id }}"
                                class="h-10 w-10 rounded-full object-cover border border-app"
                                alt="avatar">

                            <div class="leading-tight">
                                <div class="text-sm font-semibold text-app">{{ $u->first_name }} {{ $u->last_name }}</div>
                                <div class="text-xs text-app-muted">@{{ $u->username }}</div>
                            </div>
                        </div>

                        <form action="{{ route('friends.store', $u->user_id) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="recipient_id" value="{{ $u->user_id }}">
                            <button
                                type="submit"
                                class="px-4 py-2 rounded-full bg-white border border-app text-sm font-semibold text-app hover:bg-gray-50">
                                Follow
                            </button>
                        </form>
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