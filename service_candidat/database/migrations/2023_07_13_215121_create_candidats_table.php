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
            $table->string('cin')->unique();
            $table->string('id_user')->unique();
            $table->unsignedBigInteger('autoEcole_id')->nullable();;
            $table->string('nom');
            $table->string('prenom');
            $table->string('gsm');
            $table->string('adresse');
            $table->integer('age');
            $table->string('categorie');
            $table->string('langue');
            $table->string('besoin')->nullable();
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
