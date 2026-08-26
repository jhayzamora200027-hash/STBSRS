<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditObserver
{
    public function created(Model $model): void
    {
        $this->record('created', $model, null, $model->getAttributes());
    }

    public function updated(Model $model): void
    {
        $changes = $model->getChanges();
        $oldValues = [];

        foreach (array_keys($changes) as $key) {
            $oldValues[$key] = $model->getOriginal($key);
        }

        $this->record('updated', $model, $oldValues, $changes);
    }

    public function deleted(Model $model): void
    {
        $this->record('deleted', $model, $model->getOriginal(), null);
    }

    private function record(string $event, Model $model, ?array $oldValues, ?array $newValues): void
    {
        $sensitive = ['password', 'remember_token', 'token'];

        $redact = static function (?array $values) use ($sensitive): ?array {
            if ($values === null) {
                return null;
            }

            foreach ($sensitive as $field) {
                if (array_key_exists($field, $values)) {
                    $values[$field] = '[REDACTED]';
                }
            }

            return $values;
        };

        AuditLog::create([
            'user_id' => Auth::id(),
            'event' => $event,
            'auditable_type' => $model::class,
            'auditable_id' => $model->getKey(),
            'old_values' => $redact($oldValues),
            'new_values' => $redact($newValues),
            'url' => app()->runningInConsole() ? null : request()->fullUrl(),
            'ip_address' => app()->runningInConsole() ? null : request()->ip(),
            'user_agent' => app()->runningInConsole() ? null : request()->userAgent(),
        ]);
    }
}