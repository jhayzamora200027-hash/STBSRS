<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->string('attachment');
            $table->string('attachment_path');
            $table->string('file_type');
            $table->unsignedBigInteger('file_size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            Schema::table('table', function(Blueprint $table){
                $table->dropColumn([
                    'ticket_id',
                    'attachment',
                    'attachment_path',
                    'file_type',
                    'file_size'
                ]);
            });
    }
};
