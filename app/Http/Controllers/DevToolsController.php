<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DevToolsController extends Controller
{
    public function jsonFormatter()
    {
        return view('tools.dev.json-formatter');
    }

    public function processJsonFormatter(Request $request)
    {
        $request->validate(['json' => 'required|string']);
        
        try {
            $decoded = json_decode($request->json, false, 512, JSON_THROW_ON_ERROR);
            $formatted = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            return response()->json(['result' => $formatted]);
        } catch (\JsonException $e) {
            return response()->json(['error' => 'Invalid JSON: ' . $e->getMessage()], 422);
        }
    }

    public function htmlEntities()
    {
        return view('tools.dev.html-entities');
    }

    public function processHtmlEntities(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'type' => 'required|in:encode,decode'
        ]);

        if ($request->type === 'encode') {
            $result = htmlentities($request->text, ENT_QUOTES, 'UTF-8');
        } else {
            $result = html_entity_decode($request->text, ENT_QUOTES, 'UTF-8');
        }

        return response()->json(['result' => $result]);
    }

    public function jsMinifier()
    {
        return view('tools.dev.js-minifier');
    }

    public function processJsMinifier(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        // Simple regex-based minification for demo (real minifiers are complex)
        $code = $request->code;
        
        // Remove multi-line comments
        $code = preg_replace('!/\*.*?\*/!s', '', $code);
        // Remove single-line comments
        $code = preg_replace('!//.*?\n!s', '', $code);
        // Remove whitespaces around operators and brackets
        $code = preg_replace('/\s*([\{\}\(\)\[\]\+\-\*\/=\.,:;])\s*/', '$1', $code);
        // Replace multiple spaces with one
        $code = preg_replace('/\s+/', ' ', $code);
        
        return response()->json(['result' => trim($code)]);
    }
}
