<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Smalot\PdfParser\Parser;

class DocumentEmbeddingService
{
    public function search($question)
    {
        $documents = $this->documents();
        $questionEmbedding = $this->embedding($question);

        $results = [];

        foreach ($documents as $document) {

            $score = app(VectorService::class)
                ->similarity(
                    $questionEmbedding,
                    $document['embedding']
                );

            if ($score >= 0.50) {
                $results[] = [
                    'score' => $score,
                    'text' => $document['text']
                ];
            }
        }

        usort(
            $results,
            fn($a,$b) => 
            $b['score'] <=> $a['score']
        );

        if (!$results) {
            return null;
        }

        return implode(
            "\n\n",
            array_column(
                array_slice($results,0,5),
                'text'
            )
        );
    }


    private function documents()
    {
        return Cache::rememberForever(
            'istaksyon_documents',
            function () {

                $files = [
                    base_path(
                        'public/files/Data Privacy.pdf'
                    ),
                    base_path(
                        'public/files/Standard IS Documentation STB Service Request System.pdf'
                    ),
                    base_path(
                        'public/files/iSTaksyon facts.xlss'
                    )
                ];

                $documents = [];

                foreach ($files as $file) {

                    if (!file_exists($file)) {
                        continue;
                    }

                    $text = (new Parser())
                        ->parseFile($file)
                        ->getText();

                    $text = iconv('UTF-8', 'UTF-8//IGNORE', $text) ?: '';

                    $chunks = [];
                    $textLength = mb_strlen($text, 'UTF-8');

                    for ($offset = 0; $offset < $textLength; $offset += 1000) {
                        $chunks[] = mb_substr($text, $offset, 1000, 'UTF-8');
                    }

                    foreach ($chunks as $chunk) {
                        $embedding = $this->embedding($chunk);

                        if (! is_array($embedding)) {
                            continue;
                        }

                        $documents[] = [
                            'text' => $chunk,
                            'embedding' => $embedding
                        ];
                    }
                }

                return $documents;
            }
        );
    }


    private function embedding($text)
    {
        $response = Http::timeout(30)->post(
            'http://127.0.0.1:11434/api/embeddings',
            [
                'model' => 'nomic-embed-text',
                'prompt' => $text
            ]
        );

        $embedding = $response->json('embedding');

        return is_array($embedding) ? $embedding : null;
    }
}