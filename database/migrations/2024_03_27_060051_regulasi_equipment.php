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
        Schema::create('regulasi_equipment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('regulation_no')->nullable();
            $table->string('regulation_desc')->nullable();
            $table->string('category')->nullable();
            $table->text('document_k3')->nullable();
            $table->datetime('check_frequency')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regulasi_equipment');
    }
};
