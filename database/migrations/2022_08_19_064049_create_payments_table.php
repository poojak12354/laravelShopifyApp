<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('qid');
            $table->string('transaction_id',255)->nullable();
            $table->string('charge_id',255)->nullable();
            $table->string('trasaction_status',100)->default('pending');
            $table->string('amount',10);
            $table->string('currency',255);
            $table->text('billing_info')->nullable();
            $table->text('comment_note')->nullable();
            $table->text('reciept_url')->nullable();
            $table->tinyInteger('straighten')->nullable();;
            $table->string('resize',10)->nullable();;
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
        Schema::dropIfExists('payments');
    }
}
