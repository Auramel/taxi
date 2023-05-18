<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tg_users', function (Blueprint $table) {
            $table->after('has_debt', function (Blueprint $table) {
                $table->string('card_cash')->default(0);
                $table->string('cash')->default(0);
                $table->string('shift_debt')->default(0);
            });
        });
    }

    public function down(): void
    {
        Schema::table('tg_users', function (Blueprint $table) {
            $table->dropColumn('card_cash');
            $table->dropColumn('cash');
            $table->dropColumn('shift_debt');
        });
    }
};
