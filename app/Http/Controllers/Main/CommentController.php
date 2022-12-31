<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Listing;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'listing_id' => 'nullable|exists:listings,id',
            'comment_id' => 'nullable|exists:comments,id',
        ]);

        if (! $request->listing_id && ! $request->comment_id) {
            return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
        }

        $comment = new comment;
        $comment->body = $request->comment;
        $comment->user_id = auth()->user()->id;

        if ($request->comment_id) {
            $parent_comment = Comment::findOrFail($request->comment_id);
            $comment->reply_on = $parent_comment->id;
            $listing = $parent_comment->commentable;
        } else {
            $listing = Listing::findOrFail($request->listing_id);
        }

        $comment->commentable_id = $listing->id;
        $comment->commentable_type = 'App\Models\Listing';

        if ($comment->save()) {
            $c = '';
            if (! $comment->reply_on) {
                $c = '<div class="comment deletable" data-comment-id="'.$comment->id.'">';
            }
            $c .= view('main.listings.partials.comment')->with(['comment' => $comment, 'listing' => $listing])->render();
            if (! $comment->reply_on) {
                $c .= '</div>';
            }

            return response()->json([
                'parent_id' => isset($parent_comment) ? $parent_comment->id : null,
                'comment' => $c,
            ], 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    public function update(Request $request)
    {
        $comment = Comment::findOrFail($request->commentId);
        $comment->body = $request->comment;

        if ($comment->save()) {
            return response()->json($comment->body, 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    public function destroy(Listing $listing, Comment $comment)
    {
        $this->authorize('delete', $comment);

        if ($comment->delete()) {
            return response()->json('تم حذف التعليق بنجاح', 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }
}
