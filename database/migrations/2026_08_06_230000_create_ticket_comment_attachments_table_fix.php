<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('ticket_comment_attachments')) {
            Schema::create('ticket_comment_attachments', function (Blueprint $table) {
                $table->id();

                $table->foreignId('ticket_comment_id')
                    ->constrained('ticket_comments')
                    ->cascadeOnDelete();

                $table->string('original_name');
                $table->string('file_name');
                $table->string('file_path');
                $table->string('mime_type')->nullable();
                $table->unsignedBigInteger('file_size')->nullable();

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('ticket_comment_attachments')) {
            Schema::dropIfExists('ticket_comment_attachments');
        }
    }
};
