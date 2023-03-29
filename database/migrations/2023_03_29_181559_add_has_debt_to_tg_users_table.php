<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tg_users', function (Blueprint $table) {
            $table->integer('has_debt')
                ->after('phone')
                ->default(0);
        });
    }

    public function down()
    {
        Schema::table('tg_users', function (Blueprint $table) {
            $table->dropColumn('has_debt');
        });
    }
};
