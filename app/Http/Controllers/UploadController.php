<?php

namespace App\Http\Controllers;

use App\Models\MaterialType; 
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __invoke()
    {
        $materialTypes = MaterialType::all();

        return view('uploads.material', ['materialTypes' => $materialTypes]);
    }
}
