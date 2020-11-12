<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('added_id')->length(11)->unsigned();
            $table->foreign('added_id')->references('id')->on('admin')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('union_id')->length(11)->unsigned();
            $table->foreign('union_id')->references('id')->on('union')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('ward_id')->length(11)->unsigned();
            $table->foreign('ward_id')->references('id')->on('ward')->onDelete('restrict')->onUpdate('cascade');
            $table->string('name',250);
            $table->string('father_name',250);
            $table->string('mother_name',250);
            $table->string('contact_number',250);
            $table->string('dob',250);
            $table->string('blood_group',250);
            $table->mediumText('address');
            $table->string('image',250);
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
        Schema::drop('candidates');
    }
}
