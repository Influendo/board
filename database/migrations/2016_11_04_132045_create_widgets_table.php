<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Store all board widgets
 */
class CreateWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid')->index()->unique();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('board_id')->index();
            $table->string('title')->nullable();
            $table->string('type')->index();
            $table->string('position')->index()->default('auto');
            $table->text('settings')->nullable();
            $table->integer('order')->index()->default(0);
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('widgets');
    }
}
