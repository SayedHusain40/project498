<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\File;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StoreMaterialController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'course_id' => 'required',
            'material_type_id' => 'required|exists:material_types,id',
            'file' => 'required|min:1',
        ]);

        $temporaryFiles = TemporaryFile::all();
        $temporaryFilesCount = $temporaryFiles->count();

        if ($validator->fails()) {
            foreach ($temporaryFiles as $temporaryFile) {
                $this->deleteTemporaryFiles($temporaryFile);
            }
            return redirect('/up')->withErrors($validator)->withInput();
        }

        $material = Material::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'material_type_id' => $request->material_type_id,
            'file_count' => $temporaryFilesCount,
        ]);

        foreach ($temporaryFiles as $temporaryFile) {
            // Store the original file name
            $originalFileName = $temporaryFile->file;

            // Generate a unique file name using a timestamp or unique ID
            $uniqueFileName = time() . '_' . $originalFileName;

            $finalPath = "public/files/{$uniqueFileName}";

            Storage::move("public/files/tmp/{$temporaryFile->folder}/{$temporaryFile->file}", $finalPath);

            File::create([
                'material_id' => $material->id,
                'name' => $originalFileName, // Store the original file name here
                'path' => $finalPath,
                'file_type' => $temporaryFile->file_type,
            ]);

            $this->deleteTemporaryFiles($temporaryFile);
        }

        return redirect('/up');
    }

    private function deleteTemporaryFiles($temporaryFile)
    {
        $folderPath = 'public/files/tmp/' . $temporaryFile->folder;
        if (Storage::deleteDirectory($folderPath)) {
            Log::info("Deleted directory: " . $folderPath);
        } else {
            Log::warning("Failed to delete directory: " . $folderPath);
        }
        $temporaryFile->delete();
    }
}
