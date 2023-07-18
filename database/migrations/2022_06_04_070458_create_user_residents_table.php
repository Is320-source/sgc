<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserResidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_residents', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->integer('user_id')->nullable();
            $table->integer('apartament_id')->nullable();
            $table->integer('number_family')->nullable();
            $table->string('bi', 255)->nullable();
            $table->string('contract', 255)->nullable();
            $table->enum('status', ['0', '1', '2'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_residents');
    }
}
