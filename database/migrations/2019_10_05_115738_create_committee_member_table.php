<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommitteeMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committee_member', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('added_id')->length(11)->unsigned();
            $table->foreign('added_id')->references('id')->on('admin')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('union_id')->length(11)->unsigned();
            $table->foreign('union_id')->references('id')->on('union')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('designation_id')->length(11)->unsigned();
            $table->foreign('designation_id')->references('id')->on('designation')->onDelete('restrict')->onUpdate('cascade');
            $table->string('member_name',250);
            $table->string('designation',250);
            $table->string('organization_name',250);
            $table->string('village',250);
            $table->string('mobile',250);
            $table->mediumText('remark');
            $table->tinyInteger('status')->comment("1 = Active 2 = Deactive");
            $table->date('created_at');
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
        Schema::drop('committee_member');
    }
}