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
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('partials.right-sidebar', function ($view) {

            /**
             * ✅ HIGHLIGHTS OF THE WEEK (works on every page with right-sidebar)
             */
            $allowed = ['academic','events','announcement','campus_life','help_wanted'];

            $activeCategory = request()->query('category'); // /feed?category=academic
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

            // labels only (no icons)
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
             * ✅ WHO TO FOLLOW (your existing code, kept)
             */
            $authUser = Auth::user();

            if (!$authUser) {
                $view->with('whoToFollow', collect());
                $view->with('followMap', []);
                return;
            }

            // Get all users you are currently following
            $followingRows = Friend::query()
                ->where('user_id_1', $authUser->user_id)
                ->where('status', 'following')
                ->get(['user_id_2']);

            $followingIds = $followingRows->pluck('user_id_2')->values();

            // Map for quick status check in Blade: user_id => 'following'
            $followMap = [];
            foreach ($followingIds as $id) {
                $followMap[$id] = 'following';
            }

            // Suggestions: exclude yourself; we DO NOT exclude following here so it can show "Following" state
            $whoToFollow = User::query()
                ->where('user_id', '!=', $authUser->user_id)
                ->inRandomOrder()
                ->limit(4)
                ->get();

            $view->with('whoToFollow', $whoToFollow);
            $view->with('followMap', $followMap);
        });
    }
}
