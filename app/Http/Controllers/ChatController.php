<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|max:1000'
        ]);

        $message = $request->message;

        

        $systemPrompt = "
        You are PayFactor AI Assistant.
        Help users professionally.
        Answer briefly and clearly.
        ";

        $response = Http::withoutVerifying()->post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . env('GEMINI_API_KEY'),
            [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $systemPrompt . "\n\nUser: " . $message
                            ]
                        ]
                    ]
                ]
            ]
        );

        $history = session()->get('chat_history', []);

        $history[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $message]
            ]
        ];

        $data = $response->json();

        $reply = $data['candidates'][0]['content']['parts'][0]['text']
            ?? 'No response';

        $history[] = [
            'role' => 'model',
            'parts' => [
                ['text' => $reply]
            ]
        ];

        session()->put('chat_history', $history);

        return response()->json([
            'reply' => $reply
        ]);
    }
}