<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WarsMigration extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    if (!Schema::hasTable('api')) {
      Schema::create('api', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name')->default('');
      });
    }

    if (!Schema::hasTable('rait')) {
      Schema::create('rait', function (Blueprint $table) {
        $table->integer('item_id');
        $table->integer('api_id');
        $table->integer('score');
      });
    }

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('api');
    Schema::dropIfExists('rait');
  }
}
