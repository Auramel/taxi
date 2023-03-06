<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tg_hash_routes', function (Blueprint $table) {
            $table->id();
            $table->string('hash');
            $table->text('data');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tg_hash_routes');
    }
};
