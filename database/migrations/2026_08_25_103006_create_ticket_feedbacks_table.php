<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_feedbacks', function (Blueprint $table) {
            $table->id();

            // Related ticket
            $table->foreignId('ticket_id')
                ->constrained('tickets')
                ->cascadeOnDelete();

            // Overall Satisfaction
            $table->unsignedTinyInteger('overall_satisfaction')
                ->nullable()
                ->comment('Rating from 1 to 5');

            // Rate Your Experience
            $table->unsignedTinyInteger('timeliness')
                ->nullable()
                ->comment('Rating from 1 to 5');

            $table->unsignedTinyInteger('professionalism')
                ->nullable()
                ->comment('Rating from 1 to 5');

            $table->unsignedTinyInteger('quality_of_resolution')
                ->nullable()
                ->comment('Rating from 1 to 5');

            $table->unsignedTinyInteger('ease_of_process')
                ->nullable()
                ->comment('Rating from 1 to 5');

            $table->unsignedTinyInteger('communication')
                ->nullable()
                ->comment('Rating from 1 to 5');

            // Optional comments
            $table->text('additional_comments')->nullable();

            $table->timestamps();

            // One feedback per ticket
            $table->unique('ticket_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_feedbacks');
    }
};
