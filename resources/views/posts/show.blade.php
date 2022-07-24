@extends('layouts.app')

@section('content')

    <div class="card">
        @if(session('message'))
            <div class="alert alert-info">{{session('message')}}</div>
        @endif
        <div class="card-header">{{$post->title}}</div>

        <div class="card-body">
            @if($post->post_url !='')
                <div class="mb-2">
                    <a href="{{$post->post_url  }}" target="_blank">{{$post->post_url}}</a>
                </div>
            @endif
            @if($post->post_image != '')
                <img src=" {{asset('storage/posts/' . $post->id . '/thumbnail_' . $post->post_image)}}"
                     alt="post image"/>
                <br>
            @endif
            {{$post->post_text}}
            @auth()
                <hr>
                <h3>Comments</h3>
                @forelse($post->comments as $comment)
                    <b>{{$comment->user->name}}</b>
                    <br>
                    {{$comment->created_at->diffForHumans()}}
                    <p class="mt-2">{{$comment->comment_text}}</p>
                @empty
                    No Comments yet
                @endforelse
                <hr>
                <form action="{{route('posts.comments.store',$post)}}" method="POST">
                    @csrf
                    <h5>Add comment</h5>

                    <textarea name="comment_text" id="" cols="30" rows="5" required></textarea>
                    <br>
                    <button class="btn btn-sm btn-info" type="submit"> Post Comment</button>

                </form>
                    <hr>
                    @can('edit-post',$post)

                        <a href=" {{route('communities.posts.edit',[$community,$post])}}"
                           class="btn-primary btn btn-sm">Edit
                            Post</a>
                    @endcan
{{--                usig gates to speficy permissions--}}
                @can('delete-post',$post)



                    <form method="POST" style="display: inline-block"
                          action="{{route('communities.posts.destroy',[$community,$post])}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are  you sure')">
                            Delete Post
                        </button>
                    </form>
                    @else
                        <br>
                        <form method="POST" style="display: inline-block"
                              action="{{route('post.report',$post->id)}}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are  you sure')">
                                Report Post
                            </button>
                        </form>

                @endcan
            @endauth
        </div>
    </div>

@endsection
