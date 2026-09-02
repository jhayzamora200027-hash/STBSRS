<?php

namespace App\Http\Controllers;

use App\Services\OllamaService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function chat(Request $request, OllamaService $ollama): array
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        return $ollama->chat(
            $data['message']
        );
    }
}