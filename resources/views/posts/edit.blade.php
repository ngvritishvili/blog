@extends('layouts.app')
@section('content')
    @can('Comment:create')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h2 class="m-3 font-weight-bold">New Post</h2>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Go Back</a>

                    <div class="card my-2">
                        <div class="card-header">Update data</div>
                        <form action="{{ route('posts.update', $post) }}" method="post">
                            @csrf @method('PATCH')
                            <div class="card-body">
                                <input class="form-control m-2"
                                       name="published_date"
                                       value="{{ $post->published_date }}"
                                       type="datetime-local">
                                <input value="{{ $post->title }}" class="form-control m-2" name="title" placeholder="Title">
                                <textarea class="form-control m-2" placeholder="Article" name="body">{{ $post->body }}</textarea>
                                <div class="px-4 pt-2">
                                    <button class="btn btn-success">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    @endcan
@endsection
