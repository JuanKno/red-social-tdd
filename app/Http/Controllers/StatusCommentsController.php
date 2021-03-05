<?php

namespace App\Http\Controllers;

use App\Model\Comment;
use App\Model\Status;
use Illuminate\Http\Request;

class StatusCommentsController extends Controller
{
    public function store(Status $status, Request $request)
    {
        Comment::create([
            'user_id' => auth()->id(),
            'status_id' => $status->id,
            'body' => $request->body
        ]);
    }
}
