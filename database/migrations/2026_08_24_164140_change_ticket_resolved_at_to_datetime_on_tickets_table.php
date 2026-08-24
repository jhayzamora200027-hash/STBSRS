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
    Schema::table('tickets', function (Blueprint $table) {
        $table->dateTime('ticket_resolved_at')->nullable()->change();
    });
}

public function down(): void
{
    Schema::table('tickets', function (Blueprint $table) {
        $table->date('ticket_resolved_at')->nullable()->change();
    });
}
};
