@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="m-3 font-weight-bold">Post ID: {{ $post->id }}</h2>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Go Back</a>

                <div class="card my-2">
                    <div class="card-header">{{ $post->title }}</div>
                    <div class="card-body">
                        <article>{{ $post->body }}</article>
                        <div class="px-4 pt-2">
                            @foreach($post->comments as $comment)
                                <div class="my-2 p-2 bg-secondary text-white col-9 d-inline-block">{{ $comment->body }}</div>
                                @can('delete', $comment)
                                    <form class="col-2 d-inline-block"
                                          method="post"
                                          action="{{ route('comments.destroy', $comment->id) }}">
                                        @csrf @method('delete')
                                        <button type="submit" id="delete_comment" class="btn btn-danger">Delete</button>
                                    </form>
                                @endcan
                            @endforeach
                        </div>
                        <form action="{{ route('comments.store') }}" method="post">
                            @csrf
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end border border-warning">
                                <textarea name="body" class="form-control" cols="1" rows="1"></textarea>
                                <input name="post_id" hidden value="{{ $post->id }}">
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-primary justify-right"
                                    @cannot('Comment:create') disabled @endcan>Reply</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
