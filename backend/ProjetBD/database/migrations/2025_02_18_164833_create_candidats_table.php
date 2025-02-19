<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatsTable extends Migration
{
    public function up()
    {
        Schema::create('candidats', function (Blueprint $table) {
            $table->increments('idCandidat');
            $table->string('numeroCarteElecteur', 20)->unique();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->date('dateNaissance');
            $table->string('email', 100);
            $table->string('telephone', 20);
            $table->string('partiPolitique', 100)->nullable();
            $table->text('slogan')->nullable();
            $table->string('couleursParti', 255)->nullable();
            $table->binary('photo')->nullable();
            $table->string('urlInfo', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidats');
    }
}

