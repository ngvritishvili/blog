<?php

namespace App\Services;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;

class PostService
{
    public function index()
    {
        return Post::with(['comments','owner'])->orderByDesc('created_at')->paginate(10);
    }

    public function store(StorePostRequest $request)
    {
        return Post::create($request->validated());
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
       return $post->update($request->validated());
    }
}
