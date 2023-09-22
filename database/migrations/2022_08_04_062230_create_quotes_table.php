<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('fname',255);
            $table->string('lname',255);
            $table->string('email',255);
            $table->string('currency',255);
            $table->enum('image_complexity', ['easy', 'medium', 'hard'])->default('easy');
            $table->text('services');
            $table->string('file_type',255);
            $table->text('comment');
            $table->integer('images_count');
            $table->string('total_amount');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotes');
    }
}
