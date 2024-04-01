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
        Schema::create('equipment_license', function (Blueprint $table) {
            $table->increments('id');
            $table->string('doc_no');
            $table->string('company');
            $table->datetime('filing_date')->nullable();
            $table->string('tag_number')->nullable();
            $table->string('owner_asset')->nullable();
            $table->string('location_asset')->nullable();
            $table->text('document_requirements')->nullable();
            $table->integer("idRegulasi")->nullable()->unsigned();
            $table->foreign("idRegulasi")->references("id")->on('regulasi_equipment');
            $table->string('last_inspection')->nullable();
            $table->double('estimated_cost')->nullable();
            $table->enum('status', [
                'wait_dep',
                'wait_adm_legal',
                'wait_dep_hrd',
                'wait_adm_hse',
                'wait_dep_hse',
                'wait_budgetcontrol',
                'in_progress_prpo',
                'license_running',
                'draft',
                'reject',
            ])->default('wait_dep');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_license');
    }
};
