<?php

namespace App\Providers;

use App\Models\Community;
use App\Models\Post;
use App\Models\PostVote;
use App\Observers\PostVoteObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //use bootstrap pagination instead of the default which is tailwind
        Paginator::useBootstrap();

        View::share('newestPosts', Post::with('community')->latest()->take(10)->get());
        View::share('newestCommunities', Community::withCount('posts')->latest()->take(10)->get());

        PostVote::observe(PostVoteObserver::class);

    }
}
