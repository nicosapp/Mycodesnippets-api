<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_infos', function (Blueprint $table) {
      $table->id();
      $table->string('lastname')->nullable();
      $table->string('firstname')->nullable();
      $table->string('phone_number')->nullable();
      $table->string('theme', 10)->nullable();
      $table->timestamps();

      $table->bigInteger('user_id')->length(20)->unsigned()->index();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('user_infos');
  }
}
