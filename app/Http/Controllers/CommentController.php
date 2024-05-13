<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    // store comment
    public function store(Request $request, $post_id)
    {
        // validate
        Validator::make($request->all(), [
            'content' => 'required',
        ])->validate();
        // store (array format)
        $data = [
            'user_id' => Auth::user()->id,
            'post_id' => $post_id,
            'content' => $request->content,
        ];
        if(Comment::create($data)){ // if success,
            return back()->with(['success' => 'comment successfully.']);
        }
        // if failed,
        return back()->with(['error' => 'Something went wrong']);
    }
}
