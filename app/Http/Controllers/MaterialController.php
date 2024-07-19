<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Course;
use App\Models\Follow;
use App\Models\MaterialType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ZipArchive;


class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $courses = Course::all();
        $materialTypes = MaterialType::all();
        $userId = Auth::id(); 

        $materials = Material::with('course', 'materialType', 'user')
        ->when($request->course_code, function ($query) use ($request) {
            return $query->whereHas('course', function ($q) use ($request) {
                $q->where('code', $request->course_code);
            });
        })
            ->when($request->material_type_id, function ($query) use ($request) {
                return $query->where('material_type_id', $request->material_type_id);
            })
            ->get()
            ->map(function ($material) use ($userId) {
                $material->is_followed = Follow::where('user_id', $userId)->where('material_id', $material->id)->exists();
                return $material;
            });

        return view('materials.index', compact('courses', 'materialTypes', 'materials'));
    }


    public function show(Material $material)
    {
        $files = $material->files()->get();
        return view('materials.show', compact('material', 'files'));
    }
    public function downloadAll(Material $material)
    {
        $zip = new ZipArchive;
        $fileName = $material->title . '_files.zip';

        if ($zip->open(storage_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = $material->files;

            foreach ($files as $file) {
                $filePath = storage_path('app/' . $file->path);
                $relativeName = basename($filePath);
                $zip->addFile($filePath, $relativeName);
            }

            $zip->close();
        }

        return response()->download(storage_path($fileName))->deleteFileAfterSend(true);}

}
