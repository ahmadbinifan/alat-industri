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
        Schema::create('detail_equipment_license', function (Blueprint $table) {
            $table->increments('id');
            $table->string('doc_no');
            $table->string('license_no')->nullable();
            $table->string('license_from')->nullable();
            $table->date('issued_date_document')->nullable();
            $table->date('last_license_date')->nullable();
            $table->date('reminder_checking_date')->nullable();
            $table->date('reminder_testing_date')->nullable();
            $table->string('frequency_check')->nullable();
            $table->string('re_license')->nullable();
            $table->string('frequency_testing')->nullable();
            $table->date('re_license_testing')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_equipment_license');
    }
};
