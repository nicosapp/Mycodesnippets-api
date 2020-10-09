<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('categories', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->integer('order')->nullable();
      $table->timestamps();
      $table->bigInteger('parent_id')->length(20)->unsigned()->index()->nullable();
      $table->bigInteger('user_id')->length(20)->unsigned()->index();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('categories');
  }
}
