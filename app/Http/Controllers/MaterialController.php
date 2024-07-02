<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Course;
use App\Models\MaterialType;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $courses = Course::all();
        $materialTypes = MaterialType::all();

        $materials = QueryBuilder::for(Material::class)
            ->with(['files', 'user', 'course', 'materialType'])
            ->allowedFilters(['course.code', 'material_type_id'])
            ->when($request->course_code, function ($query, $courseCode) {
                $query->whereHas('course', function ($query) use ($courseCode) {
                    $query->where('code', 'like', '%' . strtolower($courseCode) . '%');
                });
            })
            ->when($request->material_type_id, function ($query, $materialTypeId) {
                $query->where('material_type_id', $materialTypeId);
            })
            ->get();

        return view('materials', compact('materials', 'courses', 'materialTypes'));
    }
}
