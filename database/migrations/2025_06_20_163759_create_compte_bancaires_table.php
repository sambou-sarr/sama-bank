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
        Schema::create('compte_bancaires', function (Blueprint $table) {
            $table->id();
            $table->string('numb_compte');
            $table->string('code_banque');
            $table->string('code_guichet');
            $table->string('cle_RIB');
            $table->integer('solde');
            $table->string('type_compte');
            $table->string('statut');
            $table->string('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compte_bancaires');
    }
};
