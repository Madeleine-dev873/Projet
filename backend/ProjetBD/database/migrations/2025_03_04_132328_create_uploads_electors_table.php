<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('uploads_electors', function (Blueprint $table) {
            $table->id();
            $table->string('filename'); // Nom du fichier
            $table->text('reason'); // Raison ou message associé
            $table->string('user_ip'); // Adresse IP de l'utilisateur
            $table->unsignedBigInteger('user_id'); // Clé étrangère vers la table users
            $table->timestamps(); // created_at et updated_at

            // Clé étrangère
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('uploads_electors');
    }
};
