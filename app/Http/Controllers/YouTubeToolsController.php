<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YouTubeToolsController extends Controller
{
    public function thumbnailDownloader()
    {
        return view('tools.youtube.thumbnail-downloader');
    }

    public function processThumbnail(Request $request)
    {
        $url = $request->input('url', '');
        
        // Extract ID from URL
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $matches);
        
        $videoId = $matches[1] ?? null;

        if (!$videoId) {
            return response()->json(['error' => 'Invalid YouTube URL'], 422);
        }

        $thumbnails = [
            'maxres' => "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg",
            'high' => "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg",
            'medium' => "https://img.youtube.com/vi/{$videoId}/mqdefault.jpg",
            'default' => "https://img.youtube.com/vi/{$videoId}/default.jpg",
        ];

        return response()->json([
            'id' => $videoId,
            'thumbnails' => $thumbnails
        ]);
    }

    public function tagExtractor()
    {
        return view('tools.youtube.tag-extractor');
    }

    public function processTagExtractor(Request $request)
    {
        $url = $request->input('url', '');
        
        try {
            $html = file_get_contents($url);
            if (!$html) throw new \Exception('Could not fetch page');

            // Extract Title
            preg_match('/<title>(.*?)<\/title>/', $html, $titleMatches);
            $title = str_replace(' - YouTube', '', $titleMatches[1] ?? 'Unknown Title');

            // Extract Tags/Keywords
            preg_match('/<meta name="keywords" content="(.*?)">/', $html, $tagMatches);
            $tags = $tagMatches[1] ?? '';
            
            // Fallback for newer YT versions (sometimes tags are in scripts)
            if (!$tags) {
                preg_match('/"keywords":\[(.*?)\]/', $html, $scriptMatches);
                $tags = str_replace(['"', '[', ']'], '', $scriptMatches[1] ?? '');
            }

            return response()->json([
                'title' => $title,
                'tags' => $tags ? explode(',', $tags) : []
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to extract data. Make sure it is a valid YouTube video URL.'], 422);
        }
    }
}
