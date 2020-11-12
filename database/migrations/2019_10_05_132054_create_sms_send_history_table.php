<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsSendHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_send_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('added_id')->length(11)->unsigned();
            $table->foreign('added_id')->references('id')->on('admin')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('union_id')->length(11)->unsigned();
            $table->foreign('union_id')->references('id')->on('union')->onDelete('restrict')->onUpdate('cascade');
            $table->mediumText('message');
            $table->mediumText('member_id');
            $table->mediumText('member_mobile');
            $table->integer('sms_number');
            $table->integer('total_sms_number');
            $table->date('created_at');
            $table->time('created_time');
            $table->date('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sms_send_history');
    }
}
