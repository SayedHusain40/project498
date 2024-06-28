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
            'course_id' => 'required'  
        ]);

        // Get all temporary files
        $temporaryFiles = TemporaryFile::all();

        // If validation fails, delete temporary files and return with errors
        if ($validator->fails()) {
            foreach ($temporaryFiles as $temporaryFile) {
                $folderPath = 'files/tmp/' . $temporaryFile->folder;
                if (Storage::deleteDirectory($folderPath)) {
                    Log::info("Deleted directory: " . $folderPath);
                } else {
                    Log::warning("Failed to delete directory: " . $folderPath);
                }
                $temporaryFile->delete();
            }
            return redirect('/up')->withErrors($validator)->withInput();
        }

        // Create the material record
        $material = Material::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id  
        ]);

        // Handle file uploads and move from temporary storage
        foreach ($temporaryFiles as $temporaryFile) {
            $finalPath = 'files/' . $temporaryFile->file;

            Storage::move('files/tmp/' . $temporaryFile->folder . '/' . $temporaryFile->file, $finalPath);

            File::create([
                'material_id' => $material->id,
                'name' => $temporaryFile->file,
                'path' => $finalPath,
                'file_type' => $temporaryFile->file_type,
            ]);

            // Delete temporary file record
            $temporaryFile->delete();

            // Try deleting the temporary folder (in case it's empty now)
            $folderPath = 'files/tmp/' . $temporaryFile->folder;
            if (Storage::deleteDirectory($folderPath)) {
                Log::info("Deleted directory: " . $folderPath);
            } else {
                Log::warning("Failed to delete directory: " . $folderPath);
            }
        }

        // Redirect to the desired route after successful upload
        return redirect('/up');
    }
}
