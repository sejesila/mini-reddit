@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Most Popular Posts</div>

                <div class="card-body">
                    @foreach($posts as $post)
                        <div class="row">
                            <div class="col-1 text-center">
                                <div>
                                    <a href="{{route('post.vote',[$post->id,1])}}">
                                        <i class="fa fa-2x fa-sort-asc" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <b>{{$post->votes}}</b>
                                <div>
                                    <a href="{{route('post.vote',[$post->id,-1])}}">
                                        <i class="fa fa-2x fa-sort-desc" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
{{--                            @livewire('post-votes',['post'=>$post])--}}

                            <div class="col-11">
                                <a href="{{ route('communities.posts.show',[$post->community,$post]) }}"><h5>{{$post->title}}</h5></a>
                                <p>{{$post->created_at->diffForHumans()}}</p>
                                {{--                    limit words to 15 then show ellipsis--}}
                                <p>{{Str::words($post->post_text,15)}}</p>
                            </div>

                        </div>

                        <hr>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
