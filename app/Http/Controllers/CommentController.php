<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Material;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{

    public function storeComment(Request $request, Material $material)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->material_id = $material->id;
        $comment->user_id = auth()->id();
        $comment->content = $validated['content'];
        $comment->save();

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'user_name' => auth()->user()->name,
                'created_at' => $comment->created_at->diffForHumans(),
                'content' => $comment->content,
                'likes' => $comment->likes,
                'dislikes' => $comment->dislikes
            ]
        ]);
    }

    public function storeReply(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $reply = new Comment();
        $reply->material_id = $comment->material_id;
        $reply->user_id = auth()->id();
        $reply->content = $validated['content'];
        $reply->parent_id = $comment->id;
        $reply->save();

        return response()->json([
            'success' => true,
            'reply' => [
                'id' => $reply->id,
                'user_name' => auth()->user()->name,
                'created_at' => $reply->created_at->diffForHumans(),
                'content' => $reply->content,
                'parent_name' => $comment->user->name

            ]
        ]);
    }


    public function likeDislikeComment(Request $request, Comment $comment, $action)
    {
        $user = Auth::user();

        DB::transaction(function () use ($comment, $user, $action) {
            if ($action === 'like') {
                if ($comment->dislikes()->where('user_id', $user->id)->exists()) {
                    $comment->dislikes()->where('user_id', $user->id)->delete();
                    $comment->decrement('dislikes');
                }

                if ($comment->likes()->where('user_id', $user->id)->exists()) {
                    $comment->likes()->where('user_id', $user->id)->delete();
                    $comment->decrement('likes');
                } else {
                    $comment->likes()->create(['user_id' => $user->id]);
                    $comment->increment('likes');
                }
            } elseif ($action === 'dislike') {
                if ($comment->likes()->where('user_id', $user->id)->exists()) {
                    $comment->likes()->where('user_id', $user->id)->delete();
                    $comment->decrement('likes');
                }

                if ($comment->dislikes()->where('user_id', $user->id)->exists()) {
                    $comment->dislikes()->where('user_id', $user->id)->delete();
                    $comment->decrement('dislikes');
                } else {
                    $comment->dislikes()->create(['user_id' => $user->id]);
                    $comment->increment('dislikes');
                }
            }
        });

        return response()->json(['success' => true, 'comment' => $comment->refresh()]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully.'
        ]);
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        if ($comment->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $comment->content = $request->content;
        $comment->save();

        return response()->json(['success' => true, 'content' => $comment->content]);
    }

}
