<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function myIP(Request $request)
    {
        $ip = $request->ip();
        return view('tools.analysis.my-ip', compact('ip'));
    }

    public function domainToIP()
    {
        return view('tools.analysis.domain-to-ip');
    }

    public function processDomainToIP(Request $request)
    {
        $domain = $request->input('domain', '');
        $domain = str_replace(['http://', 'https://'], '', $domain);
        $domain = rtrim($domain, '/');

        $ip = gethostbyname($domain);

        if ($ip === $domain) {
            return response()->json(['error' => 'Could not resolve domain'], 422);
        }

        return response()->json(['domain' => $domain, 'ip' => $ip]);
    }

    public function whoisLookup()
    {
        return view('tools.analysis.whois-lookup');
    }

    public function processWhois(Request $request)
    {
        $domain = strtolower(trim($request->input('domain', '')));
        $domain = str_replace(['http://', 'https://', 'www.'], '', $domain);
        $domain = rtrim($domain, '/');

        if (!$domain) {
            return response()->json(['error' => 'Please enter a valid domain'], 422);
        }

        // Basic validation
        if (!preg_match('/^[a-z0-9-]+\.[a-z]{2,}$/i', $domain)) {
            return response()->json(['error' => 'Invalid domain format'], 422);
        }

        // We will use a public WHOIS API for reliability in this environment
        try {
            $response = file_get_contents("https://whoisjs.com/api/v1/lookup?domain={$domain}");
            if (!$response) throw new \Exception('Failed to fetch WHOIS data');
            
            $data = json_decode($response, true);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not retrieve WHOIS data. Please try again later.'], 500);
        }
    }

    public function domainAge()
    {
        return view('tools.analysis.domain-age');
    }

    public function ipGeolocation()
    {
        return view('tools.analysis.ip-geolocation');
    }

    public function processIpGeolocation(Request $request)
    {
        $ip = $request->input('ip', $request->ip());
        
        try {
            $response = file_get_contents("http://ip-api.com/json/{$ip}?fields=status,message,country,countryCode,regionName,city,zip,lat,lon,timezone,isp,org,as,query");
            $data = json_decode($response, true);
            
            if ($data['status'] === 'fail') {
                return response()->json(['error' => $data['message']], 422);
            }
            
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch geolocation data'], 500);
        }
    }

    public function processDomainAge(Request $request)
    {
        $domain = strtolower(trim($request->input('domain', '')));
        $domain = str_replace(['http://', 'https://', 'www.'], '', $domain);
        $domain = rtrim($domain, '/');

        try {
            $response = file_get_contents("https://whoisjs.com/api/v1/lookup?domain={$domain}");
            if (!$response) throw new \Exception('Failed to fetch data');
            
            $data = json_decode($response, true);
            $createdDate = $data['createdDate'] ?? null;

            if (!$createdDate) {
                return response()->json(['error' => 'Could not find creation date for this domain.'], 422);
            }

            $created = new \DateTime($createdDate);
            $now = new \DateTime();
            $diff = $now->diff($created);

            return response()->json([
                'domain' => $domain,
                'created' => $created->format('Y-m-d'),
                'age' => [
                    'years' => $diff->y,
                    'months' => $diff->m,
                    'days' => $diff->d
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to calculate domain age.'], 500);
        }
    }
}
