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
        Schema::create('caisses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id'); 
            $table->unsignedBigInteger('id_per');  
            $table->text('motif')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->decimal('verser', 10, 2)->nullable();
            $table->decimal('reste', 10, 2)->nullable();
            $table->text('lettre')->nullable();
            $table->string('etatCaisse')->default('attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caisses');
    }
};
