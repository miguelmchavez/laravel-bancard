<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBancardRollbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bancard_rollbacks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('shop_process_id');
            $table->string('status');
            $table->string('key');
            $table->string('level');
            $table->string('dsc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bancard_rollbacks');
    }
}
