<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function toggleBookmark(Request $request)
    {
        $fileId = $request->file_id;
        $userId = Auth::id();

        $bookmark = Bookmark::where('user_id', $userId)->where('file_id', $fileId)->first();

        if ($bookmark) {
            // Remove bookmark
            $bookmark->delete();
            return response()->json(['status' => 'removed']);
        } else {
            // Add bookmark
            Bookmark::create([
                'user_id' => $userId,
                'file_id' => $fileId
            ]);
            return response()->json(['status' => 'added']);
        }
    }
    public function index()
    {
        $userId = Auth::id();
        $bookmarks = Bookmark::where('user_id', $userId)->with('file')->get();

        return view('bookmarks.index', compact('bookmarks'));
    }
}
