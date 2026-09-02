<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Smalot\PdfParser\Parser;

class DocumentEmbeddingService
{
    public function search(string $question): ?string
    {
        $terms = $this->terms($question);

        if ($terms === []) {
            return null;
        }

        $results = [];

        foreach ($this->documents() as $document) {
            $searchableText = strtolower($document['text']);
            $score = 0;

            foreach ($terms as $term) {
                $score += substr_count($searchableText, $term);
            }

            if ($score > 0) {
                $results[] = [
                    'score' => $score,
                    'text' => $document['text'],
                ];
            }
        }

        usort($results, fn ($a, $b) => $b['score'] <=> $a['score']);

        if ($results === []) {
            return null;
        }

        return implode("\n\n", array_column(array_slice($results, 0, 2), 'text'));
    }

    private function terms(string $question): array
    {
        $words = preg_split('/[^a-z0-9]+/i', strtolower($question), -1, PREG_SPLIT_NO_EMPTY);
        $stopWords = ['about', 'and', 'are', 'can', 'does', 'how', 'the', 'this', 'what', 'when', 'where', 'which', 'with', 'you'];
        $synonyms = [
            'ticket' => ['ticket', 'request'],
            'submit' => ['submit', 'create'],
        ];
        $terms = [];

        foreach ($words as $word) {
            if (strlen($word) < 3 || in_array($word, $stopWords, true)) {
                continue;
            }

            foreach ($synonyms[$word] ?? [$word] as $term) {
                $terms[] = $term;
            }
        }

        return array_values(array_unique($terms));
    }

    private function documents(): array
    {
        return Cache::rememberForever('istaksyon_documents_text', function (): array {
            $files = [
                base_path('public/files/Data Privacy.pdf'),
                base_path('public/files/Standard IS Documentation STB Service Request System.pdf'),
                base_path('public/files/iSTaksyon facts.xlsx'),
            ];
            $documents = [];

            foreach ($files as $file) {
                if (! is_file($file)) {
                    continue;
                }

                $text = $this->readDocument($file);
                $length = mb_strlen($text, 'UTF-8');

                for ($offset = 0; $offset < $length; $offset += 1200) {
                    $chunk = trim(mb_substr($text, $offset, 1200, 'UTF-8'));

                    if ($chunk !== '') {
                        $documents[] = ['text' => $chunk];
                    }
                }
            }

            return $documents;
        });
    }

    private function readDocument(string $file): string
    {
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if ($extension === 'pdf') {
            return trim((new Parser())->parseFile($file)->getText());
        }

        if (in_array($extension, ['xlsx', 'xls'], true)) {
            $spreadsheet = IOFactory::load($file);
            $rows = [];

            foreach ($spreadsheet->getAllSheets() as $sheet) {
                foreach ($sheet->toArray(null, true, true, false) as $row) {
                    $values = array_filter(array_map(
                        static fn ($value): string => trim((string) $value),
                        $row
                    ), static fn (string $value): bool => $value !== '');

                    if ($values !== []) {
                        $rows[] = implode(' | ', $values);
                    }
                }
            }

            return trim(implode("\n", $rows));
        }

        return '';
    }
}
