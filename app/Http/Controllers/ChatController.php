<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('ai.chat');
    }

    public function process(Request $request)
    {
        $message = $request->input('message', '');

        if (!$message) {
            return response()->json(['error' => 'Message is empty'], 422);
        }

        // Infrastructure ready for AI API integration (Gemini/OpenAI)
        // For now, we return a smart mock response
        $response = $this->getMockResponse($message);

        return response()->json([
            'reply' => $response
        ]);
    }

    private function getMockResponse($message)
    {
        $message = strtolower($message);
        
        if (str_contains($message, 'seo')) {
            return "SEO (Search Engine Optimization) is the process of improving your site to increase its visibility for relevant searches. ToolOrbit helps you with this by providing tools like Meta Tag Generators and Sitemap creators!";
        }

        if (str_contains($message, 'whois')) {
            return "WHOIS lookup allows you to find the registration details of any domain name, including its owner and expiry date. You can find our WHOIS tool in the 'Website Tracking' section.";
        }

        return "I am OrbitAI, your SEO assistant. I'm currently in 'Optimization Mode'. How can I help you improve your website today?";
    }
}
