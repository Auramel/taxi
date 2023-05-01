<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taxoparks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('park_id');
            $table->string('client_id');
            $table->string('api_key');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taxoparks');
    }
};
