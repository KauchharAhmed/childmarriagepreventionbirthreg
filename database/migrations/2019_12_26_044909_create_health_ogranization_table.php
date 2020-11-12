<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthOgranizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_organization', function (Blueprint $table) {
            $table->integer('union_id')->length(11)->unsigned();
            $table->foreign('union_id')->references('id')->on('union')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('ward_id')->length(11)->unsigned();
            $table->foreign('ward_id')->references('id')->on('ward')->onDelete('restrict')->onUpdate('cascade');
            $table->string('ogranization_name',250);
            $table->string('contact_number',250);
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
        Schema::drop('health_organization');
    }
}
