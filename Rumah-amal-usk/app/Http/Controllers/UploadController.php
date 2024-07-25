<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
            $url = asset('uploads/' . $fileName);

            return response()->json([
                'url' => $url,
            ]);
        }

        return response()->json(['message' => 'File upload failed.'], 400);
    }
}

