<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBancardUserCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bancard_user_cards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->string('user_cell_phone');
            $table->string('user_mail');
            $table->string('alias_token')->nullable();
            $table->string('card_masked_number')->nullable();
            $table->string('expiration_date')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_type', 20)->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });

        DB::statement('ALTER Table bancard_user_cards add card_id INTEGER NOT NULL UNIQUE AUTO_INCREMENT;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bancard_user_cards');
    }
}
