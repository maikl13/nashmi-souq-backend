<?php

namespace App\Http\Controllers\Main;

use App\Models\Comment;
use App\Models\Listing;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Listing $listing)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        $comment = new comment;
        $comment->body = $request->comment;
        $comment->user_id = auth()->user()->id;
        $comment->commentable_id = $listing->id;
        $comment->commentable_type = 'App\Models\Listing';

        if($comment->save()){
            return view('main.listings.partials.comment')->with(['comment' => $comment, 'listing' => $listing]);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    public function update(Request $request)
    {
        $comment = Comment::findOrFail($request->commentId);
        $comment->body = $request->comment;
        
        if($comment->save()){
            return response()->json($comment->body , 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    public function destroy(Listing $listing, Comment $comment)
    {
        $this->authorize('delete', $comment);

        if($comment->delete())
            return response()->json('تم حذف التعليق بنجاح' , 200);

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }
}
