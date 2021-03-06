<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_infos', function (Blueprint $table) {
            $table->id();
            $table->string('wallet_id');
            $table->string('sender')->nullable();
            $table->string('account_number')->nullable();
            $table->bigInteger('deposit_amount')->nullable();
            $table->string('proof')->nullable();
            $table->date('sent_date')->nullable();
            $table->string('status')->default('not approved');
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
        Schema::dropIfExists('deposit_infos');
    }
}
