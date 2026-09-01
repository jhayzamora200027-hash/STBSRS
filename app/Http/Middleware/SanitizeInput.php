<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SanitizeInput
{
    public function handle(Request $request, Closure $next)
    {
        $request->merge($this->validateInput($request->all()));

        return $next($request);
    }

    private function validateInput(array $input): array
    {
        foreach ($input as $key => $value) {
            if ($this->isSecretField((string) $key)) {
                continue;
            }

            if ($this->containsMarkup($value)) {
                throw ValidationException::withMessages([
                    (string) $key => 'HTML and script markup are not allowed.',
                ]);
            }
        }

        return $this->trimStrings($input);
    }

    private function containsMarkup(mixed $value): bool
    {
        if (is_array($value)) {
            foreach ($value as $item) {
                if ($this->containsMarkup($item)) {
                    return true;
                }
            }

            return false;
        }

        return is_string($value) && (
            preg_match('/<\/?[a-z][^>]*>/i', $value) === 1
            || preg_match('/(?:javascript\s*:|data\s*:\s*text\/html|on[a-z]+\s*=)/i', $value) === 1
        );
    }

    private function trimStrings(mixed $value): mixed
    {
        if (is_array($value)) {
            return array_map(fn (mixed $item): mixed => $this->trimStrings($item), $value);
        }

        return is_string($value) ? trim($value) : $value;
    }

    private function isSecretField(string $key): bool
    {
        return in_array($key, [
            '_token',
            'password',
            'password_confirmation',
            'current_password',
        ], true);
    }
}
