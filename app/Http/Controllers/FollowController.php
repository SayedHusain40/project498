<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function followedMaterials()
    {
        $userId = Auth::id();
        $followedMaterials = Material::whereIn('id', function ($query) use ($userId) {
            $query->select('material_id')
                ->from('follows')
                ->where('user_id', $userId);
        })->get()
            ->map(function ($material) use ($userId) {
                $material->is_followed = true; 
                return $material;
            });

        return view('materials.followed', compact('followedMaterials'));
    }

    public function toggleFollow(Request $request)
    {
        $userId = Auth::id();
        $materialId = $request->material_id;

        $follow = Follow::where('user_id', $userId)->where('material_id', $materialId)->first();

        if ($follow) {
            // Unfollow
            $follow->delete();
            return response()->json(['status' => 'unfollowed']);
        } else {
            // Follow
            Follow::create([
                'user_id' => $userId,
                'material_id' => $materialId,
            ]);
            return response()->json(['status' => 'followed']);
        }
    }
}
