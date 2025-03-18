<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('electeurs', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->string('nom'); // Nom de l'électeur
            $table->string('prenom'); // Prénom de l'électeur
            $table->date('date_naissance'); // Date de naissance
            $table->string('numero_carte')->unique(); // Numéro de carte unique
            $table->string('adresse'); // Adresse
            $table->string('telephone'); // Numéro de téléphone
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electeurs');
    }
};
