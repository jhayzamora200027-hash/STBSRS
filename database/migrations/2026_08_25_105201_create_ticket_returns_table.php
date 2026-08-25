<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_returns', function (Blueprint $table) {
            $table->id();

            // Related ticket
            $table->foreignId('ticket_id')
                ->constrained()
                ->cascadeOnDelete();

            // Return details
            $table->text('return_reason');

            $table->enum('urgency', [
                'low',
                'medium',
                'high',
                'urgent'
            ])->default('medium');

            // Who returned the ticket
            $table->foreignId('returned_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Tracking
            $table->timestamp('returned_at')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_returns');
    }
};