<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecurityController extends Controller
{
    public function passwordGenerator()
    {
        return view('tools.security.password-generator');
    }

    public function md5Generator()
    {
        return view('tools.security.md5-generator');
    }

    public function processMd5(Request $request)
    {
        $text = $request->input('text', '');
        return response()->json([
            'hash' => md5($text)
        ]);
    }

    public function base64Encoder()
    {
        return view('tools.security.base64');
    }

    public function processBase64(Request $request)
    {
        $text = $request->input('text', '');
        $type = $request->input('type', 'encode');

        if ($type === 'encode') {
            $result = base64_encode($text);
        } else {
            $result = base64_decode($text);
        }

        return response()->json([
            'result' => $result
        ]);
    }
}
