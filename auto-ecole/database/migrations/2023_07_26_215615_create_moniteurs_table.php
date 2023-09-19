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
        Schema::create('moniteurs', function (Blueprint $table) {
            $table->string('id_moniteur')->primary();
            $table->string('id_user')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone');
            $table->string('autoEcole_id');
            $table->foreign('autoEcole_id')->references('autoEcole_id')->on('auto_ecoles')->onDelete('cascade');
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moniteurs');
    }
};
