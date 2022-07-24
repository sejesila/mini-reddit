<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()

    {
        $posts = Post::with('community')->withCount([
            'votesRel' => function ($query) {
                $query->where('post_votes.created_at', '>', now()->subDays(2))
                    ->where('vote', 1);
            }
        ])->orderByDesc('votes_rel_count')->take(6)->get();
//        dd($posts);
        return view('home', compact('posts'));
    }
}
