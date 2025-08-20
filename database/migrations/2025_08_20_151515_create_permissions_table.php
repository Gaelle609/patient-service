<?php

use App\Models\Permission;
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
         Schema::create('permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // -------- Categories --------
        Permission::create(['name' => 'create-patient']);
        Permission::create(['name' => 'view-patient']);
        Permission::create(['name' => 'update-patient']);
        Permission::create(['name' => 'delete-patient']);

        // -------- Articles --------
        Permission::create(['name' => 'create-service']);
        Permission::create(['name' => 'view-service']);
        Permission::create(['name' => 'update-service']);
        Permission::create(['name' => 'delete-service']);
        
     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
