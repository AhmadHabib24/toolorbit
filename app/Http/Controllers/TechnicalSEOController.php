<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TechnicalSEOController extends Controller
{
    public function sslChecker()
    {
        return view('tools.seo.ssl-checker');
    }

    public function processSslChecker(Request $request)
    {
        $request->validate(['url' => 'required|string']);
        
        $url = parse_url($request->url, PHP_URL_HOST) ?: $request->url;
        
        try {
            $context = stream_context_create([
                "ssl" => [
                    "capture_peer_cert" => true,
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ]
            ]);

            $client = @stream_socket_client("ssl://" . $url . ":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context);
            
            if (!$client) {
                throw new \Exception("Could not connect to host: $errstr");
            }

            $params = stream_context_get_params($client);
            $cert = openssl_x509_parse($params['options']['ssl']['peer_certificate']);

            return response()->json([
                'issuer' => $cert['issuer']['O'] ?? ($cert['issuer']['CN'] ?? 'Unknown'),
                'subject' => $cert['subject']['CN'] ?? 'Unknown',
                'valid_from' => date('Y-m-d H:i:s', $cert['validFrom_time_t']),
                'valid_until' => date('Y-m-d H:i:s', $cert['validTo_time_t']),
                'is_valid' => (time() < $cert['validTo_time_t'] && time() > $cert['validFrom_time_t']),
                'signature_type' => $cert['signatureTypeLN'] ?? 'Unknown',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function headerChecker()
    {
        return view('tools.seo.header-checker');
    }

    public function processHeaderChecker(Request $request)
    {
        $request->validate(['url' => 'required|url']);

        try {
            $response = Http::withHeaders(['User-Agent' => 'ToolOrbit-SEO-Bot/1.0'])->get($request->url);
            
            return response()->json([
                'status' => $response->status(),
                'headers' => $response->headers(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not fetch headers.'], 422);
        }
    }

    public function redirectChecker()
    {
        return view('tools.seo.redirect-checker');
    }

    public function processRedirectChecker(Request $request)
    {
        $request->validate(['url' => 'required|url']);

        try {
            $response = Http::withHeaders(['User-Agent' => 'ToolOrbit-SEO-Bot/1.0'])
                ->followRedirects()
                ->get($request->url);

            $transferStats = $response->handlerStats();
            $redirectCount = $transferStats['redirect_count'] ?? 0;
            $finalUrl = $transferStats['url'] ?? $request->url;

            return response()->json([
                'redirect_count' => $redirectCount,
                'final_url' => $finalUrl,
                'status_code' => $response->status(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not trace redirects.'], 422);
        }
    }
}
