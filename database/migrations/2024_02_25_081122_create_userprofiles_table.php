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
        Schema::create('userprofiles', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->id();

            $table->string('profile_name', 30);
            $table->string('picture')->nullable();
            $table->string('link_x')->nullable();
            $table->string('link_fb')->nullable();
            $table->string('link_insta')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('state', 20)->nullable();
            $table->integer('number_of_child')->nullable();
            $table->string('introduction', 1000)->nullable();
            $table->string('hobby', 1000)->nullable();
            $table->string('topic', 1000)->nullable();
            $table->string('easy_to_talk', 100)->nullable();
            $table->string('purpose1')->nullable();
            $table->string('purpose2')->nullable();
            $table->string('purpose3')->nullable();
            $table->string('purpose4')->nullable();
            $table->string('purpose5')->nullable();
            $table->string('purpose6')->nullable();
            $table->string('interest1')->nullable();
            $table->string('interest2')->nullable();
            $table->string('interest3')->nullable();
            $table->string('interest4')->nullable();
            $table->string('interest5')->nullable();
            $table->string('interest6')->nullable();
            $table->string('interest7')->nullable();
            $table->string('interest8')->nullable();
            $table->string('interest9')->nullable();
            $table->string('interest10')->nullable();
            $table->string('interest11')->nullable();
            $table->string('interest12')->nullable();
            $table->string('interest13')->nullable();
            $table->string('interest14')->nullable();
            $table->string('interest15')->nullable();
            $table->string('name_of_child1')->nullable();
            $table->string('sex1')->nullable();
            $table->date('birth_date_of_child1')->nullable();
            $table->string('name_of_child2')->nullable();
            $table->string('sex2')->nullable();
            $table->date('birth_date_of_child2')->nullable();
            $table->string('name_of_child3')->nullable();
            $table->string('sex3')->nullable();
            $table->date('birth_date_of_child3')->nullable();
            $table->string('name_of_child4')->nullable();
            $table->string('sex4')->nullable();
            $table->date('birth_date_of_child4')->nullable();
            $table->string('name_of_child5')->nullable();
            $table->string('sex5')->nullable();
            $table->date('birth_date_of_child5')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userprofiles');
    }
};
