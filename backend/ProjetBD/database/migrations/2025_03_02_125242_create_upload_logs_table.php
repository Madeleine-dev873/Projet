<<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {


public function up()
{
    Schema::table('electeurs', function (Blueprint $table) {
        $table->string('nom')->after('id');
        $table->string('prenom')->after('nom');
        $table->date('date_naissance')->after('prenom');
        $table->string('numero_carte')->unique()->after('date_naissance');
        $table->string('adresse')->after('numero_carte');
        $table->string('telephone')->after('adresse');
    });
}
};