@extends('layouts.app')

@section('content')

            <div class="card">
                <div class="card-header">
                    <div class="row">
                <div class="col-8">
                    <h1>{{$community->name}}</h1>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ route('communities.show',$community) }}"
                       @if(request('sort' ,'') =='') style="font-size: 20px" @endif> Newest Posts</a>
                    <br>
                    <a href="{{ route('communities.show',$community) }}?sort=popular"
                       @if(request('sort' ,'') =='popular') style="font-size: 20px" @endif>Popular</a>
                </div>
                </div>
                </div>

                <div class="card-body">
                    <a href="{{ route('communities.posts.create',$community) }}" class="btn btn-primary">Add Post</a>
                    <br><br>
                    @forelse($posts as $post)
                        <div class="row">
                            @livewire('post-votes',['post'=>$post])

                            <div class="col-11">
                                <a href="{{ route('communities.posts.show',[$community,$post]) }}"><h5>{{$post->title}}</h5></a>
                                <p>{{$post->created_at->diffForHumans()}}</p>
                                {{--                    limit words to 15 then show ellipsis--}}
                                <p>{{Str::words($post->post_text,15)}}</p>
                            </div>

                        </div>

                        <hr>
                    @empty
                        No posts found
                    @endforelse
{{--                    pagination--}}
                    {{$posts->links()}}

                </div>
            </div>

@endsection
