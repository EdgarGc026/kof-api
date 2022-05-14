<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      Schema::create('characters', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('url')->nullable();
        $table->string('fullname')->nullable();
        $table->text('birthday')->nullable();
        $table->string('weight')->nullable();
        $table->string('height')->nullable();
        $table->string('bloodType')->nullable();
        $table->text('relatives')->nullable();
        $table->text('occupation')->nullable();
        $table->text('likes')->nullable();
        $table->text('hates')->nullable();
        $table->text('hobbies')->nullable();
        $table->text('favoriteFood')->nullable();
        $table->text('sportSkill')->nullable();
        $table->text('specialSkill')->nullable();
        $table->text('favoriteMusic')->nullable();
        $table->text('measures')->nullable();
        $table->text('guns')->nullable();
        $table->text('fightStyle')->nullable();
        $table->text('avatar')->nullable();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('characters');
    }
}
