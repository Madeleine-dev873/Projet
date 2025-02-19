<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('upload_logs', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('reason');
            $table->ipAddress('user_ip');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('attempted_at')->useCurrent();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('upload_logs');
    }
};
