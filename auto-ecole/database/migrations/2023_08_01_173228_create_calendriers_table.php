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
        Schema::create('calendriers', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('Type');
            $table->string('autoEcole_id');
            $table->string('id_moniteur');
            $table->biginteger('id_categorie');
            $table->unsignedBigInteger('id_vehicule')->nullable();
            $table->timestamps();
            $table->foreign('autoEcole_id')->references('autoEcole_id')->on('auto_ecoles')->onDelete('cascade');
            $table->foreign('id_moniteur')->references('id_moniteur')->on('moniteurs');
            $table->foreign('id_vehicule')->references('id_vehicule')->on('vehicules');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendriers');
    }
};
