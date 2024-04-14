<?php

namespace App\Services;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;

class CommentService
{
    public function store(StoreCommentRequest $request)
    {
        return Comment::create($request->validated());
    }
}
