<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',250);
            $table->string('designation',250);
            $table->string('email',250);
            $table->string('mobile',250)->unique();
            $table->string('password',250);
            $table->string('recover_code',250);
            $table->string('image',250);
            $table->tinyInteger('type')->comment("1 = Admin 2 = Others");
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
        Schema::drop('admin');
    }
}
