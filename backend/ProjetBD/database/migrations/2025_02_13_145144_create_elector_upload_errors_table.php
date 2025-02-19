<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectorUploadErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('elector_upload_errors', function (Blueprint $table) {
        $table->id();
        $table->foreignId('upload_attempt_id')->constrained('elector_upload_attempts')->onDelete('cascade');
        $table->text('error_message');
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
        Schema::dropIfExists('elector_upload_errors');
    }
}
