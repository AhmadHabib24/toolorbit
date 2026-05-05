<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuditController extends Controller
{
    public function seoChecker()
    {
        return view('tools.audit.seo-checker');
    }

    public function processSeoChecker(Request $request)
    {
        $url = $request->input('url');
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Invalid URL format'], 422);
        }

        try {
            $response = Http::withHeaders(['User-Agent' => 'ToolOrbit-Audit-Bot/1.0'])->get($url);
            $html = $response->body();

            $data = [
                'title' => $this->getMatch($html, '/<title>(.*?)<\/title>/is'),
                'description' => $this->getMeta($html, 'description'),
                'h1' => $this->getMatchAll($html, '/<h1>(.*?)<\/h1>/is'),
                'h2' => $this->getMatchAll($html, '/<h2>(.*?)<\/h2>/is'),
                'images' => $this->countMatches($html, '/<img/is'),
                'images_no_alt' => $this->countMatches($html, '/<img(?!.*?alt=)/is'),
                'links' => $this->countMatches($html, '/<a/is'),
                'status' => $response->status(),
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not analyze URL: ' . $e->getMessage()], 500);
        }
    }

    private function getMatch($html, $pattern) {
        preg_match($pattern, $html, $matches);
        return $matches[1] ?? 'Not found';
    }

    private function getMatchAll($html, $pattern) {
        preg_match_all($pattern, $html, $matches);
        return $matches[1] ?? [];
    }

    private function getMeta($html, $name) {
        preg_match('/<meta.*?name=["\']' . $name . '["\'].*?content=["\'](.*?)["\'].*?>/is', $html, $matches);
        if (!$matches) {
            preg_match('/<meta.*?content=["\'](.*?)["\'].*?name=["\']' . $name . '["\'].*?>/is', $html, $matches);
        }
        return $matches[1] ?? 'Not found';
    }

    private function countMatches($html, $pattern) {
        return preg_match_all($pattern, $html, $matches);
    }

    public function colorPalette()
    {
        return view('tools.audit.color-palette');
    }

    public function urlEncoder()
    {
        return view('tools.audit.url-encoder');
    }

    public function processUrlEncoder(Request $request)
    {
        $text = $request->input('text', '');
        $type = $request->input('type', 'encode');
        return response()->json([
            'result' => ($type === 'encode') ? urlencode($text) : urldecode($text)
        ]);
    }
}
