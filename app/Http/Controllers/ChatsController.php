<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ChatsController extends Controller
{
    //
    public function index()
    {
        $departments = Department::all();

        return view('chats.index', compact('departments'));
    }

    public function show(Department $department)
    {

        $comments = Comment::where('department_id', $department->id)
            ->whereNull('parent_id')
            ->with(['replies' => function ($query) {
                $query->with('replies');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('chats.department', compact('department', 'comments'));
    }

    public function storeComment(Request $request, Department $department)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->department_id = $department->id;
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
        $reply->department_id = $comment->department_id;
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
