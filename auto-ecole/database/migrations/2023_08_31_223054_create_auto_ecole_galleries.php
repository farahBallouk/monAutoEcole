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
        Schema::create('auto_ecole_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('url');
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
        Schema::dropIfExists('auto_ecole_galleries');
    }
};
