<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParselinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parselinfos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('recever_name');
            $table->string('recever_email')->nullable();
            $table->string('recever_phone');
            $table->text('recever_address');
            $table->text('package_name');
            $table->text('package_quantity');
            $table->text('type');
            $table->text('weight');
            $table->string('packagestatus')->default('Onprogress')->nullable();
            $table->string('paymentstatus')->default('unpaid')->nullable();
            $table->string('source');
            $table->string('destination');
            $table->string('distance');

            $table->string('paymentmethod');
            $table->string('senderPayment_name');
            $table->string('senderPayment_phone');
            $table->double('price', 8, 2);

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
        Schema::dropIfExists('parselinfos');

    }
}
