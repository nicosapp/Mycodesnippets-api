<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('steps', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('snippet_id')->length(20)->unsigned()->index();
      $table->uuid('uuid');
      $table->string('title')->nullable();
      $table->integer('order')->unsigned()->index();
      $table->string('language')->nullable();
      $table->text('code')->nullable();
      $table->text('body')->nullable();
      $table->timestamps();


      $table->foreign('snippet_id')->references('id')->on('snippets')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('steps');
  }
}
