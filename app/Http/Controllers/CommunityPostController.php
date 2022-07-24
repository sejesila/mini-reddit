<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Community;
use App\Models\Post;
use App\Models\PostVote;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;

class CommunityPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Community $community)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function create(Community $community)
    {
        return view('posts.create', compact('community'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|\Illuminate\Http\RedirectResponse|Response|\Illuminate\Routing\Redirector
     */
    public function store(StorePostRequest $request, Community $community)
    {
        $post = $community->posts()->create([
            'author_id' => auth()->id(),
            'title' => $request->title,
            'post_text' => $request->post_text ?? null,
            'post_url' => $request->post_url ?? null,
//            'post_image' => $image
        ]);
        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image')->getClientOriginalName();
            $request->file('post_image')->storeAs('posts/'.$post->id, $image);
            $post->update(['post_image'=>$image]);

            $file = Image::make(storage_path('app/public/posts/' .$post->id . '/' .$image));
            $file->resize(320,240);
            $file->save(storage_path('app/public/posts/' .$post->id . '/thumbnail_' .$image));
        }
        return redirect()->route('communities.show', $community);
    }

    /**
     * Display the specified resource.
     *
     * @param Community $community
     * @param Post $post
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function show(Community $community, Post $post)
    {
        return view('posts.show', compact('community', 'post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Community $community
     * @param Post $post
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function edit(Community $community, Post $post)
    {
        if ($post->author_id != auth()->id()) {
            abort(403);
        }
        return view('posts.edit', compact('community', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Community $community
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StorePostRequest $request, Community $community, Post $post)
    {
        if ($post->author_id != auth()->id()) {
            abort(403);
        }
        $post->update($request->validated());
        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image')->getClientOriginalName();
            $request->file('post_image')->storeAs('posts/'.$post->id, $image);

            //delete previous image from the storage folder
            if ($post->post_image != '' && $post->post_image != $image){
                unlink(storage_path('app/public/posts/' . $post->id . '/' . $post->post_image));
                unlink(storage_path('app/public/posts/' . $post->id . '/thumbnail_' . $post->post_image));
            }
            $post->update(['post_image'=>$image]);
            $file = Image::make(storage_path('app/public/posts/' .$post->id . '/' .$image));
            $file->resize(500, null, function($constraint)
            {
                $constraint->aspectRatio();
            });

            $file->save(storage_path('app/public/posts/' .$post->id . '/thumbnail_' .$image));
        }
        return redirect()->route('communities.posts.show', [$community, $post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Community $community
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Community $community, Post $post)
    {
        if ($post->author_id != auth()->id()) {
            abort(403);
        }
        $post->delete();
        return redirect()->route('communities.show', [$community]);
    }

    public function vote($post_id,$vote)
    {
        $post = Post::with('community')->findOrFail($post_id);
        if (!PostVote::where('post_id',$post_id)->where('user_id',auth()->id())->count()
        && in_array($vote, [-1,1]) && $post->author_id != auth()->id())
        {

        PostVote::create([
            'post_id'=>$post_id,
            'user_id'=>auth()->id(),
            'vote'=>$vote
        ]);
        $post->increment('votes',$vote);
        }
        return redirect()->route('communities.show',$post->community);

    }
}
