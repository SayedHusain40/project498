<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Question;
use App\Models\Reply;
use App\Models\QuestionUserLikeDislike;
use App\Models\ReplyUserLikeDislike;
use App\Models\ReportQuestion;
use App\Models\ReportReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    //
    public function index()
    {
        $departments = Department::all();

        return view('chats.index', compact('departments'));
    }
    public function show(Department $department)
    {
        $questions = Question::where('department_id', $department->id)
            ->with(['replies.user', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('chats.department', compact('department', 'questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id'
        ]);

        $question = Question::create([
            'content' => $request->content,
            'department_id' => $request->department_id,
            'user_id' => Auth::id(),
        ]);

        $user = Auth::user();

        return response()->json([
            'success' => true,
            'question' => [
                'id' => $question->id,
                'content' => $question->content,
                'created_at' => $question->created_at,
                'user' => [
                    'name' => $user->name,
                ],
            ],
        ]);
    }

    public function storeReply(Request $request, $questionId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // Find the question by ID
        $question = Question::findOrFail($questionId);

        $reply = new Reply();
        $reply->content = $request->input('content');
        $reply->user_id = Auth::id();
        $reply->question_id = $question->id;
        $reply->save();

        $response = [
            'success' => true,
            'reply' => [
                'id' => $reply->id,
                'content' => $reply->content,
                'created_at' => $reply->created_at,
                'user' => [
                    'name' => $reply->user->name
                ]
            ]
        ];

        return response()->json($response);
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $question->update([
            'content' => $request->input('content'),
        ]);

        return response()->json(['success' => true, 'question' => $question]);
    }

    public function updateReply(Request $request, Question $question, Reply $reply)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $reply->update([
            'content' => $request->input('content'),
        ]);

        return response()->json(['success' => true, 'reply' => $reply]);
    }



    public function like(Request $request, Question $question)
    {
        $user = Auth::user();

        // Check if the user already has a like or dislike for the question
        $Action = QuestionUserLikeDislike::where('question_id', $question->id)
            ->where('user_id', $user->id)
            ->first();

        if ($Action) {
            // If user liked remove like
            if ($Action->type === 'like') {
                $question->decrement('likes');
                $Action->delete();
            } else {
                // If user disliked change dislike to like
                $question->increment('likes');
                $question->decrement('dislikes');
                $Action->update(['type' => 'like']);
            }
        } else {
            $question->increment('likes');
            QuestionUserLikeDislike::create([
                'question_id' => $question->id,
                'user_id' => $user->id,
                'type' => 'like'
            ]);
        }

        return response()->json(['likes' => $question->likes, 'dislikes' => $question->dislikes]);
    }

    public function dislike(Request $request, Question $question)
    {
        $user = Auth::user();

        // Check if the user already has a like or dislike for the question
        $action = QuestionUserLikeDislike::where('question_id', $question->id)
            ->where('user_id', $user->id)
            ->first();

        if ($action) {
            // If user disliked remove dislike
            if ($action->type === 'dislike') {
                $question->decrement('dislikes');
                $action->delete();
            } else {
                // If user liked change like to dislike
                $question->increment('dislikes');
                $question->decrement('likes');
                $action->update(['type' => 'dislike']);
            }
        } else {
            $question->increment('dislikes');
            QuestionUserLikeDislike::create([
                'question_id' => $question->id,
                'user_id' => $user->id,
                'type' => 'dislike'
            ]);
        }

        return response()->json(['likes' => $question->likes, 'dislikes' => $question->dislikes]);
    }


    public function likeReply(Request $request, $replyId)
    {
        $user = Auth::user();

        // Check if the user already has a like or dislike for the reply
        $action = ReplyUserLikeDislike::where('reply_id', $replyId)
            ->where('user_id', $user->id)
            ->first();

        $reply = Reply::findOrFail($replyId);

        if ($action) {
            // If user liked remove like
            if ($action->type === 'like') {
                $reply->decrement('likes');
                $action->delete();
            } else {
                // If user disliked change dislike to like
                $reply->increment('likes');
                $reply->decrement('dislikes');
                $action->update(['type' => 'like']);
            }
        } else {
            $reply->increment('likes');
            ReplyUserLikeDislike::create([
                'reply_id' => $replyId,
                'user_id' => $user->id,
                'type' => 'like'
            ]);
        }

        return response()->json(['likes' => $reply->likes, 'dislikes' => $reply->dislikes]);
    }

    public function dislikeReply(Request $request, $replyId)
    {
        $user = Auth::user();

        // Check if the user already has a like or dislike for the reply
        $action = ReplyUserLikeDislike::where('reply_id', $replyId)
            ->where('user_id', $user->id)
            ->first();

        $reply = Reply::findOrFail($replyId);

        if ($action) {
            // If user disliked remove dislike
            if ($action->type === 'dislike') {
                $reply->decrement('dislikes');
                $action->delete();
            } else {
                // If user liked, change like to dislike
                $reply->increment('dislikes');
                $reply->decrement('likes');
                $action->update(['type' => 'dislike']);
            }
        } else {
            $reply->increment('dislikes');
            ReplyUserLikeDislike::create([
                'reply_id' => $replyId,
                'user_id' => $user->id,
                'type' => 'dislike'
            ]);
        }

        return response()->json(['likes' => $reply->likes, 'dislikes' => $reply->dislikes]);
    }


    public function destroyQuestion(Question $question)
    {
        if (Auth::user()->id === $question->user_id) {
            $question->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }

    public function destroyReply(Reply $reply)
    {
        if (Auth::user()->id === $reply->user_id) {
            $reply->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }

    public function reportContent(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:question,reply',
            'id' => 'required|integer',
            'reason' => 'required|string|max:255',
        ]);

        if ($request->type === 'question') {
            ReportQuestion::create([
                'question_id' => $request->id,
                'user_id' =>  Auth::id(),
                'reason' => $request->reason,
            ]);
        } elseif ($request->type === 'reply') {
            ReportReply::create([
                'reply_id' => $request->id,
                'user_id' => Auth::id(), 
                'reason' => $request->reason,
            ]);
        }

        return response()->json(['success' => true]);
    }

}
