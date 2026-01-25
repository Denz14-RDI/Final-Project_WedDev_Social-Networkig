<?php
// ------------------------------------------------------------------
// This is App Service Provider uses a view composer to attach data 
// everytime the right-sidebar.blade.php is rendered.
// ------------------------------------------------------------------
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

    // --------------------------------------------------------------------------
    // In this part it prepares data for Highlights of the Week and Who to Follow
    // --------------------------------------------------------------------------
    public function boot(): void
    {
        View::composer('partials.right-sidebar', function ($view) {

            // ----------------------
            // HIGHLIGHTS OF THE WEEK
            // ----------------------

            // Only this categories are allowed and want we want to show for highlights of the week
            $allowed = ['academic', 'events', 'announcement', 'campus_life', 'help_wanted'];

            // Get active category and counts of posts per category in the last 7 days
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

            // Convert category keys to labels 
            $labels = [
                'academic'      => 'Academics',
                'events'        => 'Events',
                'announcement'  => 'Announcements',
                'campus_life'   => 'Campus Life',
                'help_wanted'   => 'Help Wanted',
            ];

            // After that it sends results to right-sidebar view
            $highlights = $counts->map(function ($row) use ($labels) {
                return [
                    'key'   => $row->category,
                    'label' => $labels[$row->category] ?? ucfirst(str_replace('_', ' ', $row->category)),
                    'total' => (int) $row->total,
                ];
            });

            $view->with('highlights', $highlights);
            $view->with('activeCategory', $activeCategory);

            // -------------
            // WHO TO FOLLOW
            // -------------

            // This will get the current logged-in user
            $authUser = Auth::user();

            if (!$authUser) {
                $view->with('whoToFollow', collect());
                $view->with('followMap', []);
                $view->with('followIdMap', []);
                return;
            }

            // This will get the list of users the current user is following including friend_id
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

            // Check if there is a "just followed" user in session
            $justFollowedId = session('just_followed');

            // Exclude the current logged-in user and already followed users
            $alreadyFollowingIds = array_keys($followMap);

            // Allow “just followed” to still appear ONCE 
            if ($justFollowedId) {
                $alreadyFollowingIds = array_values(array_diff($alreadyFollowingIds, [$justFollowedId]));
            }

            // Suggestions are random users not yet followed and limited to 4 users
            $whoToFollow = User::query()
                ->where('user_id', '!=', $authUser->user_id)
                ->when(!empty($alreadyFollowingIds), function ($q) use ($alreadyFollowingIds) {
                    $q->whereNotIn('user_id', $alreadyFollowingIds);
                })
                ->inRandomOrder()
                ->limit(4)
                ->get();

            // This will display the user that was just followed at the top of the list
            if ($justFollowedId) {
                $justFollowedUser = User::where('user_id', $justFollowedId)->first();

                if ($justFollowedUser) {
                    $whoToFollow = $whoToFollow->reject(fn($u) => $u->user_id == $justFollowedId);
                    $whoToFollow = collect([$justFollowedUser])->merge($whoToFollow)->take(4);
                }
            }

            // Pass data to the right-sidebar view
            $view->with('whoToFollow', $whoToFollow);
            $view->with('followMap', $followMap);
            $view->with('followIdMap', $followIdMap);
        });
    }
}
