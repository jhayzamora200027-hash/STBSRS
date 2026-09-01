<?php

namespace App\Services;

class VectorService
{
    public function similarity($a, $b)
    {
        $dot = 0;
        $normA = 0;
        $normB = 0;

        foreach ($a as $i => $value) {

            $dot += $value * $b[$i];

            $normA += $value * $value;

            $normB += $b[$i] * $b[$i];

        }

        if ($normA == 0 || $normB == 0) {
            return 0;
        }

        return $dot / (
            sqrt($normA) * sqrt($normB)
        );
    }
}