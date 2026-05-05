<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TextToolsController extends Controller
{
    public function wordCounter()
    {
        return view('tools.text.word-counter');
    }

    public function processWordCounter(Request $request)
    {
        $text = $request->input('text', '');
        
        $wordCount = str_word_count($text);
        $charCount = strlen($text);
        $charCountNoSpaces = strlen(str_replace(' ', '', $text));
        $sentenceCount = preg_match_all('/[.!?]/', $text, $matches);
        $lineCount = count(explode("\n", $text));

        return response()->json([
            'words' => $wordCount,
            'characters' => $charCount,
            'characters_no_spaces' => $charCountNoSpaces,
            'sentences' => $sentenceCount,
            'lines' => $lineCount,
        ]);
    }

    public function caseConverter()
    {
        return view('tools.text.case-converter');
    }

    public function processCaseConverter(Request $request)
    {
        $text = $request->input('text', '');
        $type = $request->input('type', 'upper');

        $result = match($type) {
            'upper' => strtoupper($text),
            'lower' => strtolower($text),
            'title' => ucwords(strtolower($text)),
            'sentence' => ucfirst(strtolower($text)),
            default => $text,
        };

        return response()->json(['result' => $result]);
    }

    public function removeEmojis()
    {
        return view('tools.text.remove-emojis');
    }

    public function processRemoveEmojis(Request $request)
    {
        $text = $request->input('text', '');
        
        // Basic regex to remove emojis
        $result = preg_replace('/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{1FA70}-\x{1FAFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u', '', $text);

        return response()->json(['result' => $result]);
    }

    public function loremIpsum()
    {
        return view('tools.text.lorem-ipsum');
    }
}
