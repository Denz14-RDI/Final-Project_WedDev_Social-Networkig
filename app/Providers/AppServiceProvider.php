<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Post;
use App\Models\User;
use App\Models\Friend;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('partials.right-sidebar', function ($view) {

            /**
             * ✅ HIGHLIGHTS OF THE WEEK
             */
            $allowed = ['academic', 'events', 'announcement', 'campus_life', 'help_wanted'];

            $activeCategory = request()->query('category');
            if (!in_array($activeCategory, $allowed, true)) {
                $activeCategory = null;
            }

            $since = Carbon::now()->subDays(7);

            $counts = Post::select('category', DB::raw('COUNT(*) as total'))
                ->whereIn('category', $allowed)
                ->where('created_at', '>=', $since)
                ->groupBy('category')
                ->orderByDesc('total')
                ->get();

            $labels = [
                'academic'      => 'Academics',
                'events'        => 'Events',
                'announcement'  => 'Announcements',
                'campus_life'   => 'Campus Life',
                'help_wanted'   => 'Help Wanted',
            ];

            $highlights = $counts->map(function ($row) use ($labels) {
                return [
                    'key'   => $row->category,
                    'label' => $labels[$row->category] ?? ucfirst(str_replace('_', ' ', $row->category)),
                    'total' => (int) $row->total,
                ];
            });

            $view->with('highlights', $highlights);
            $view->with('activeCategory', $activeCategory);

            /**
             * ✅ WHO TO FOLLOW (Follow -> Following then disappears on refresh)
             */
            $authUser = Auth::user();

            if (!$authUser) {
                $view->with('whoToFollow', collect());
                $view->with('followMap', []);
                $view->with('followIdMap', []);
                return;
            }

            // Get following rows including friend_id
            $followingRows = Friend::query()
                ->where('user_id_1', $authUser->user_id)
                ->where('status', 'following')
                ->whereNull('deleted_at')
                ->get(['friend_id', 'user_id_2']);

            $followMap = [];
            $followIdMap = [];

            foreach ($followingRows as $row) {
                $followMap[$row->user_id_2] = 'following';
                $followIdMap[$row->user_id_2] = $row->friend_id;
            }

            // ✅ this is the special “show Following once” user
            $justFollowedId = session('just_followed');

            // Exclude yourself + already followed
            $alreadyFollowingIds = array_keys($followMap);

            // ✅ allow “just followed” to still appear ONCE (so we can show Following)
            if ($justFollowedId) {
                $alreadyFollowingIds = array_values(array_diff($alreadyFollowingIds, [$justFollowedId]));
            }

            // Suggestions normally exclude followed users
            $whoToFollow = User::query()
                ->where('user_id', '!=', $authUser->user_id)
                ->when(!empty($alreadyFollowingIds), function ($q) use ($alreadyFollowingIds) {
                    $q->whereNotIn('user_id', $alreadyFollowingIds);
                })
                ->inRandomOrder()
                ->limit(4)
                ->get();

            // ✅ ensure “just followed” is included at top for THIS request only
            if ($justFollowedId) {
                $justFollowedUser = User::where('user_id', $justFollowedId)->first();

                if ($justFollowedUser) {
                    $whoToFollow = $whoToFollow->reject(fn($u) => $u->user_id == $justFollowedId);
                    $whoToFollow = collect([$justFollowedUser])->merge($whoToFollow)->take(4);
                }
            }

            $view->with('whoToFollow', $whoToFollow);
            $view->with('followMap', $followMap);
            $view->with('followIdMap', $followIdMap);
        });
    }
}
