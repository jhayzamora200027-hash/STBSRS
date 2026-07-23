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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id')->unique();
            $table->string('requestor_first_name');
            $table->string('requestor_middle_name')->nullable();
            $table->string('requestor_last_name');
            $table->string('requestor_extension_name')->nullable();
            $table->string('requestor_sex');
            $table->string('requestor_email');
            $table->string('requestor_region');
            $table->string('requestor_province');
            $table->string('requestor_city');
            $table->string('ticket_category');
            $table->string('purpose_of_request');
            $table->string('program');
            $table->string('type_of_knowledge_product')->nullable();
            $table->string('venue')->nullable();
            $table->string('type_of_activity')->nullable();
            $table->date('date_of_activity')->nullable();
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
            'requestor_first_name',
            'requestor_middle_name',
            'requestor_last_name',
            'requestor_extension_name',
            'requestor_sex',
            'requestor_email',
            'requestor_region',
            'requestor_province',
            'requestor_city',
            'ticket_category',
            'purpose_of_request',
            'program',
            'type_of_knowledge_product',
            'venue',
            'type_of_activity',
            'date_of_activity'
            ]);
        });
    }
};
