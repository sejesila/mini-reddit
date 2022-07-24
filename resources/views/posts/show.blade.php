@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{$post->title}}</div>

                    <div class="card-body">
                        @if($post->post_url !='')
                            <div class="mb-2">
                                <a href="{{$post->post_url  }}" target="_blank">{{$post->post_url}}</a>
                            </div>
                        @endif
                        @if($post->post_image != '')
                                <img src=" {{asset('storage/posts/' . $post->id . '/thumbnail_' . $post->post_image)}}" alt="post image"/>
                                <br>
                            @endif
                        {{$post->post_text}}
                        @auth()
                            @if($post->author_id == auth()->id())
                                    <hr>
                                    <a href=" {{route('communities.posts.edit',[$community,$post])}}" class="btn-primary btn btn-sm">Edit Post</a>
                                    <form method="POST" style="display: inline-block" action="{{route('communities.posts.destroy',[$community,$post])}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are  you sure')">Delete</button>
                                    </form>
                                @endif
                            @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection