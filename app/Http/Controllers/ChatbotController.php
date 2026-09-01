<?php

namespace App\Http\Controllers;

use App\Services\OllamaService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function chat(Request $request, OllamaService $ollama)
    {
        return $ollama->chat(
            $request->message
        );
    }
}