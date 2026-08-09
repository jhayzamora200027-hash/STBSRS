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
            $table->string('requestor_organization')->after('requestor_position_title')->nullable();
            $table->string('requestor_office')->after('requestor_organization')->nullable();
            $table->string('requestor_specific_office')->after('requestor_office')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'requestor_organization',
                'requestor_office',
                'requestor_specific_office',
            ]); 
        });
    }
};
