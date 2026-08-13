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
            $table->string('title_of_activity')->after('type_of_knowledge_product_others')->nullable();
            $table->string('target_participants')->after('title_of_activity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
             $table->dropColumn([
                'title_of_activity',
                'target_participants'
            ]); 
        });
    }
};
