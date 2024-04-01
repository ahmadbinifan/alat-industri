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
        Schema::create(
            'approval_equipment_license',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('doc_no')->nullable();
                $table->string('fullname')->nullable();
                $table->string('id_section')->nullable();
                $table->string('note')->nullable();
                $table->datetime('approved_at')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_equipment_license');
    }
};
