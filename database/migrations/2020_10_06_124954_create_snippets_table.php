<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnippetsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('snippets', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('user_id')->length(20)->unsigned()->index();
      $table->uuid('uuid');
      $table->string('title')->nullable();
      $table->string('description')->nullable();
      $table->timestamps();

      // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('snippets');
  }
}
