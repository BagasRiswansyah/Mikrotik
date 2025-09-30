<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('address_list_histories', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // CREATE, UPDATE, DELETE, ENABLE, DISABLE
            $table->string('domain_ip');
            $table->string('comment')->nullable();
            $table->string('status'); // enabled, disabled
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('user_role');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('address_list_histories');
    }
};