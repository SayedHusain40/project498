<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Course;
use App\Models\MaterialType;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
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

        return view('materials.index', compact('materials', 'courses', 'materialTypes'));
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
