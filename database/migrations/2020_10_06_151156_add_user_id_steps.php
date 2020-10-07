<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdSteps extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('steps', function (Blueprint $table) {
      $table->bigInteger('user_id')->length(20)->unsigned()->index()->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('steps', function (Blueprint $table) {
      $table->dropColumn('user_id');
    });
  }
}
