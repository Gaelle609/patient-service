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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_per_sender');
            $table->unsignedBigInteger('id_per_receiver');
            $table->timestamp('date_envoi')->useCurrent();
            $table->timestamp('date_recu')->nullable();
            $table->string('patient_id'); 
            $table->string('state')->default('non_recu');
            $table->unsignedBigInteger('id_per_recu')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
