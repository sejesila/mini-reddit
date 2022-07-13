<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommunityRequest;
use App\Http\Requests\UpdateCommunityRequest;
use App\Models\Community;
use App\Models\Topic;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;


class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function index()
    {
        $communities = Community::where('user_id',auth()->id())->get();
        return view('communities.index',compact('communities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function create()
    {
        $topics = Topic::all();
        return view('communities.create',compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(StoreCommunityRequest $request): RedirectResponse
    {
        $community = Community::create($request->validated() + ['user_id'=>auth()->id()]);
//                'slug'=>Str::slug($request->name)
        $community->topics()->attach($request->topics);
        return redirect()->route('communities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Community $community
     * @return Application|Factory|View
     */
    public function show(Community $community)
    {
        return view('communities.show',compact('community'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function edit(Community $community)
    {
        if($community->user_id != auth()->id()){
            abort(403);
        }
        $topics = Topic::all();
        $community->load('topics');
        return view('communities.edit',compact('community','topics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(UpdateCommunityRequest $request, Community $community)
    {
        if($community->user_id != auth()->id()){
            abort(403);
        }
        $community->update($request->validated());
        //Sync is a belongs to many function that accepts an array
        //it deletes the previous record of a pivot table and updates it with a new one
        $community->topics()->sync($request->topics);

        return redirect()->route('communities.index')->with('message','Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Community $community
     * @return RedirectResponse
     */
    public function destroy(Community $community): RedirectResponse
    {
        if($community->user_id != auth()->id()){
            abort(403);
        }
        $community->delete();

        return redirect()->route('communities.index')->with('message','Successfully deleted');

    }
}
