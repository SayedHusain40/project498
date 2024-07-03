<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use Illuminate\Http\Request;

class UploadTemporaryFileController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $fileType = $file->getClientOriginalExtension(); // Get the file extension
            $folder = uniqid('file-', true);
            $file->storeAs('public/files/tmp/' . $folder, $fileName);

            TemporaryFile::create([
                'folder' => $folder,
                'file' => $fileName,
                'file_type' => $fileType,
            ]);

            return $folder;
        }
        return '';
    }
}
