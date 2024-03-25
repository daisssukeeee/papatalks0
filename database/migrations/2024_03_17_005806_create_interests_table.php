<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('interests', function (Blueprint $table) {
            $table->id();
            $table->string('news');
            $table->string('business');
            $table->string('career');
            $table->string('self_enlightenment');
            $table->string('management');
            $table->string('marketing');
            $table->string('programming');
            $table->string('design');
            $table->string('health');
            $table->string('music');
            $table->string('movie');
            $table->string('camera');
            $table->string('game');
            $table->string('comic');
            $table->string('invest');
            $table->string('side_job');
            $table->string('education');
            $table->string('fashion');
            $table->string('art');
            $table->string('english');
            $table->string('cook');
            $table->string('fortune');
            $table->string('mindfulness');
            $table->string('medical');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interests');
    }
};
