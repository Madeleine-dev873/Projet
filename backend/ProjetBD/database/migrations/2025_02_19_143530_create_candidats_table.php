<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidats', function (Blueprint $table) {
            $table->id('idCandidat');
            $table->string('numeroCarteElecteur', 20)->unique();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->date('dateNaissance');
            $table->string('email', 100);
            $table->string('telephone', 20);
            $table->string('partiPolitique', 100)->nullable();
            $table->text('slogan')->nullable();
            $table->string('couleursParti', 255)->nullable();
            $table->string('photo')->nullable(); // Stocke le chemin de l'image au lieu du BLOB
            $table->string('urlInfo', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidats');
    }
}
