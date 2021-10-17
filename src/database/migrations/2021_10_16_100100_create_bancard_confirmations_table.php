<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBancardConfirmationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bancard_confirmations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('shop_process_id');
            $table->string('response', 1)->nullable();
            $table->string('response_details', 60)->nullable();
            $table->string('authorization_number', 6)->nullable();
            $table->integer('ticket_number')->nullable();
            $table->string('response_code', 2)->nullable();
            $table->string('response_description', 40)->nullable();
            $table->string('extended_response_description', 100)->nullable();
            $table->string('card_source', 1)->nullable();
            $table->string('customer_ip', 15)->nullable();
            $table->string('card_country', 30)->nullable();
            $table->string('version', 5)->nullable();
            $table->string('risk_index', 1)->nullable();
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
        Schema::dropIfExists('bancard_confirmations');
    }
}
