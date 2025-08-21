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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patient');
            $table->unsignedBigInteger('id_per')->nullable();
            $table->decimal('temperature')->nullable();
            $table->integer('poids')->nullable();
            $table->integer('tension')->nullable();
            $table->decimal('typeCon')->nullable();
            $table->text('symptome')->nullable();
            $table->text('diagnostique')->nullable();
            $table->text('examenRecom')->nullable();
            $table->date('dateAcouch')->nullable();
            $table->string('lieuAcouch')->nullable();
            $table->string('testVih')->nullable();
            $table->string('etatAcouch')->nullable();
            $table->text('signe')->nullable();
            $table->text('vaccinRecu')->nullable();
            $table->date('dategross')->nullable();
            $table->string('regle')->nullable();
            $table->string('paccouche')->nullable();
            $table->string('haemo')->nullable();
            $table->string('tpi')->nullable();
            $table->date('dateRDV')->nullable();
            $table->string('nombreJourHosp')->nullable();
            $table->string('statut')->default('Activer');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
