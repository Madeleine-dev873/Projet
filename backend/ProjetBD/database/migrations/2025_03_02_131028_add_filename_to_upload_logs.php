<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('uploads_logs', function (Blueprint $table) {
            $table->string('filename')->after('id');
            $table->text('reason')->nullable();
            $table->string('user_ip')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('uploads_logs', function (Blueprint $table) {
            $table->dropColumn(['filename', 'reason', 'user_ip', 'user_id']);
        });
    }
};
