<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageToolsController extends Controller
{
    public function imageToBase64()
    {
        return view('tools.image.base64');
    }

    public function processImageToBase64(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048' // 2MB Max
        ]);

        $image = $request->file('image');
        $base64 = 'data:' . $image->getMimeType() . ';base64,' . base64_encode(file_get_contents($image->getRealPath()));

        return response()->json([
            'base64' => $base64
        ]);
    }

    public function screenshotGenerator()
    {
        return view('tools.image.screenshot');
    }

    public function placeholderGenerator()
    {
        return view('tools.image.placeholder');
    }
}
