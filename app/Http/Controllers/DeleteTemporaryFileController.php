<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DeleteTemporaryFileController extends Controller
{
    public function __invoke(Request $request)
    {
        $folder = $request->getContent();
        $temporaryFile = TemporaryFile::where('folder', $folder)->first();

        if ($temporaryFile) {
            // Delete the directory from storage
            Storage::deleteDirectory('public/files/tmp/' . $temporaryFile->folder);
            // Delete the record from the database
            $temporaryFile->delete();
        }

        return response()->noContent();
    }
}
