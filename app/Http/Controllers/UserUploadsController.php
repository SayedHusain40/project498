<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Course;
use App\Models\Follow;
use App\Models\Restaurant;
use App\Models\StudySession;
use App\Models\Marketplace;
use App\Models\MaterialType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserUploadsController extends Controller
{
    //

    public function index(Request $request)
    {
        $courses = Course::all();
        $materialTypes = MaterialType::all();
        $userId = Auth::id();

        $materials = Material::with('course', 'materialType', 'user')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($material) use ($userId) {
                $material->is_followed = Follow::where('user_id', $userId)->where('material_id', $material->id)->exists();
                return $material;
            });
        $marketplaceItems = Marketplace::where('user_id', Auth::id())->get();
        $studySessions = StudySession::where('user_id', Auth::id())->get();
        $restaurants = Restaurant::where('user_id', Auth::id())->get();

        return view('users_uploads.index', compact('courses', 'materialTypes', 'materials', 'marketplaceItems', 'studySessions', 'restaurants'));
    }


    public function destroyMaterial($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return response()->json(['message' => 'Material deleted successfully.']);
    }

    public function destroyMarketplaceItem($id)
    {
        $item = Marketplace::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Marketplace item deleted successfully.']);
    }
    public function destroyStudySession($id)
    {
        $session = StudySession::findOrFail($id);
        $session->delete();

        return response()->json(['message' => 'Study session deleted successfully.']);
    }

    public function destroyRestaurant($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->delete();

        return response()->json(['message' => 'Restaurant deleted successfully.']);
    }

}
