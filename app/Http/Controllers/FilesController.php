<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function show()
    {
        $pathToFile = storage_path('app/GraceHopper.pdf');
        $name = 'Grace Hopper';

        return response()->download($pathToFile, $name);
    }

    public function create(Request $request)
    {
        $path = $request->file('photo')->store('photo-files'); # storage/app/photo-files/9lSWtIs5AmQXy0bJyBEMdvbK0NiiMPwzcaB1U6Pp.png
        return response()->json(['path' => $path], 200);
    }
}
