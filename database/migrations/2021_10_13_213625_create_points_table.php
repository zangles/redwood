<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('point');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('point_user', function (Blueprint $table) {
            $table->foreignId('user_id')->index();
            $table->foreignId('point_id')->index();
            $table->foreignId('period_id')->index();
            $table->date('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('points');
    }
}
