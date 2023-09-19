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
            $table->string('autoEcole_id')->primary();
            $table->string('id_user')->unique();
            $table->string('nom');
            $table->string('telephone');
            $table->string('adresse');
            $table->string('logo');
            $table->string('Type_abonnement');
            $table->string('info_fiscales');
            $table->string('localisation');
            $table->json('social');
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
