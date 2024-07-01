<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Course;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $courses = Course::get(); 

        $materials = QueryBuilder::for(Material::class)
            ->with(['files', 'user', 'course'])
            ->allowedFilters('course.code') 
            ->when($request->course_code, function ($query, $courseCode) {
                $query->whereHas('course', function ($query) use ($courseCode) {
                    $query->where('code', 'like', '%' . strtolower($courseCode) . '%');
                });
            })
            ->get();

        return view('materials', compact('materials', 'courses'));
    }
}
