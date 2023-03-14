<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->integer('income_tg_user_id');
            $table->integer('from_tg_user_id');
            $table->integer('level');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('referrals');
    }
};
