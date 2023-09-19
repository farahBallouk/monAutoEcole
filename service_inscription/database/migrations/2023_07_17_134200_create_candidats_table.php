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
        Schema::create('candidats', function (Blueprint $table) {
            $table->string('id_candidat')->primary();
            $table->string('CIN');
            $table->string('id_autoEcole')->nullable();
            $table->string('id_user');
            $table->string('nom');
            $table->string('prenom');
            $table->string('GSM');
            $table->integer('Age');
            $table->string('categorie');
            $table->string('langue');
            $table->string('Besoin')->nullable();
            $table->foreign('id_autoEcole')->references('id_autoEcole')->on('auto_ecoles')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidats');
    }
};
