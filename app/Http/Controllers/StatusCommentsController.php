<?php

namespace App\Http\Controllers;

use App\Model\Comment;
use App\Model\Status;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;

class StatusCommentsController extends Controller
{
    public function store(Status $status, Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);
        
        $comment = Comment::create([
            'user_id' => auth()->id(),
            'status_id' => $status->id,
            'body' => $request->body
        ]);

        return CommentResource::make($comment);
    }
}
