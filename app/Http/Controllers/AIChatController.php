<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AIChatController extends Controller
{  

    public function chat(Request $request)
{
    $message = $request->message;

    $prompt = "
You are PF Payroll Assistant.

User Question:
$message
";

    $response = Http::withoutVerifying()->post(
        'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . env('GEMINI_API_KEY'),
        [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $prompt
                        ]
                    ]
                ]
            ]
        ]
    );

    // Decode JSON response
    $data = $response->json();

    // Debug Gemini response
    \Log::info($data);

    // Check errors
    if (isset($data['error'])) {

        return response()->json([
            'reply' => $data['error']['message']
        ]);
    }

    // Extract Gemini text
    $reply =
        $data['candidates'][0]['content']['parts'][0]['text']
        ?? 'No response from Gemini';

    return response()->json([
        'reply' => $reply
    ]);
}
}