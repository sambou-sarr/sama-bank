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
        Schema::create('carte_bancaires', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_carte');
            $table->date('date_exp');
            $table->string('CVV');
            $table->string('statut');
            $table->integer('compte_id')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carte_bancaires');
    }
};
