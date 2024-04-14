@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between">
                    <h2 class="m-3 font-weight-bold d-flex justify-content-between">Posts</h2>
                    @can('Post:create')
                        <form action="{{ route('posts.create') }}" method="GET">
                            <button type="submit" class="btn btn-success">New Post</button>
                        </form>
                    @endcan
                </div>
                @foreach($posts as $post)
                    <div class="card my-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <a class="text-left" href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                            <span class="text-right">Views: {{ $post->views }}</span>
                            <span class="text-right">Published: {{ $post->published_date }}</span>
                        </div>
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <p class="text-left">Posted By: {{ $post->owner->name }}</p>
                            @can('Post:update', $post)
                                @if(auth()->id() == $post->owner->id)
                                    <form action="{{ route('posts.edit', $post) }}" method="get">
                                        <button
                                            type="submit"
                                            class="btn btn-warning text-right">Edit
                                        </button>
                                    </form>
                                @endif
                            @endcan
                            @can('Post:delete', $post)
                                <form action="{{ route('posts.destroy', $post) }}" method="post">
                                    @csrf @method('DELETE')
                                    @if(auth()->id() == $post->owner->id or auth()->user()->hasRole('Admin'))
                                        <button
                                            type="submit"
                                            class="btn btn-danger text-right">Delete
                                        </button>
                                    @endif
                                </form>
                            @endcan
                        </div>
                        <div class="card-body">
                            <article>{{ $post->body }}</article>
                            <div class="m-2 px-3 pt-2 container border border-info">
                                <span class="d-flex text-secondary">Comments</span>
                                @foreach($post->comments as $comment)
                                    <article class="my-2 p-2 bg-secondary text-white col-8 d-inline-block">{{ $comment->body }}</article>
                                    <span>{{ $comment->owner->name }}</span>
                                    @can('delete', $comment)
                                        @if(auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->id === $comment->owner->id))
                                            <form class="col-1 d-inline-block" method="post" action="{{ route('comments.destroy', $comment->id) }}">
                                                @csrf @method('delete')
                                                <button type="submit" id="delete_comment" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        @endif
                                    @endcan
                                @endforeach
                            </div>
                        </div>
                        <form action="{{ route('comments.store') }}" method="post">
                            @csrf
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end border border-warning">
                                <textarea placeholder="Add Comment" name="body" class="form-control" cols="1"
                                          rows="1"></textarea>
                                <input name="post_id" hidden value="{{ $post->id }}">
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-primary justify-right"
                                    @cannot('Comment:create') disabled @endcan>Reply
                                </button>
                            </div>
                        </form>

                    </div>

                @endforeach
            </div>
            <div class="Page navigation example">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {{ $posts->links() }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
