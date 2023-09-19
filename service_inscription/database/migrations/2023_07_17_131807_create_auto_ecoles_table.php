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
        Schema::create('auto_ecoles', function (Blueprint $table) {
            $table->string('id_autoEcole')->primary();
            $table->string('id_user');
            $table->string('nom');
            $table->string('telephone');
            $table->string('adresse');
            $table->string('logo');
            $table->string("Type_abonnement");
            $table->string('info_fiscales');
            $table->string('localisation');
            $table->json('social');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_ecoles');
    }
};
