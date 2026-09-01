<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Smalot\PdfParser\Parser;

class OllamaController extends Controller
{
    public function chat(Request $request): JsonResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        try {
            $documentText = Cache::remember('ollama:data-privacy-text', now()->addDay(), function () {
                $pdfPath = public_path('files/Data Privacy.pdf');

                if (! is_file($pdfPath)) {
                    throw new \RuntimeException('The Data Privacy document could not be found.');
                }

                $text = (new Parser())->parseFile($pdfPath)->getText();

                if (trim($text) === '') {
                    throw new \RuntimeException('The Data Privacy document does not contain readable text.');
                }

                return trim($text);
            });

            $response = Http::timeout((int) config('services.ollama.timeout', 90))
                ->post(rtrim(config('services.ollama.url'), '/') . '/api/generate', [
                    'model' => config('services.ollama.model', 'gemma3:4b'),
                    'stream' => false,
                    'prompt' => implode("\n\n", [
                        'You are the iSTaksyon Data Privacy Assistant.',
                        'Answer the user only from the Data Privacy Notice below.',
                        'If the answer is not stated in the document, say that you cannot find it in the Data Privacy Notice and advise the user to contact the system administrator.',
                        'Do not invent policies, requirements, deadlines, or contact details.',
                        'Keep the answer concise and easy to understand.',
                        'DATA PRIVACY NOTICE:',
                        $documentText,
                        'USER QUESTION:',
                        $data['message'],
                    ]),
                ]);

            if ($response->failed()) {
                return response()->json([
                    'message' => 'Ollama is unavailable. Start Ollama and make sure the configured model is installed.',
                ], 503);
            }

            $answer = trim((string) $response->json('response'));

            if ($answer === '') {
                return response()->json(['message' => 'The local model returned an empty response.'], 502);
            }

            return response()->json([
                'answer' => $answer,
                'source' => 'Data Privacy Notice',
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'The assistant could not read the Data Privacy Notice right now.',
            ], 503);
        }
    }
}