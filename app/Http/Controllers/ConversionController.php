<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConversionController extends Controller
{
    public function rgbHex()
    {
        return view('tools.conversion.rgb-hex');
    }

    public function binaryConverter()
    {
        return view('tools.conversion.binary');
    }

    public function jsonCsv()
    {
        return view('tools.conversion.json-csv');
    }

    public function qrCode()
    {
        return view('tools.conversion.qr-code');
    }

    public function faviconGenerator()
    {
        return view('tools.conversion.favicon-generator');
    }

    public function processJsonCsv(Request $request)
    {
        $json = $request->input('json', '');
        $data = json_decode($json, true);

        if (!$data || !is_array($data)) {
            return response()->json(['error' => 'Invalid JSON format'], 422);
        }

        // Simple JSON to CSV logic
        $headers = array_keys(is_array($data[0] ?? $data) ? ($data[0] ?? $data) : []);
        $csv = implode(',', $headers) . "\n";
        
        foreach ($data as $row) {
            $csv .= implode(',', array_values($row)) . "\n";
        }

        return response()->json(['csv' => $csv]);
    }
}
