<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->enum('genere', ['0', '1'])->nullable();
            $table->string('phone', 20)->nullable();
            $table->timestamp('isVerified')->nullable();
            $table->string('photo', 220)->nullable();
            $table->enum('status', ['0', '1', '2'])->nullable();
            $table->enum('first_login', ['0', '1'])->default('1');
            $table->string('address', 225)->nullable();
            $table->enum('type', ['0', '1', '2', '3', '4', '5', '6'])->default('2'); // 0, 1, 2 => Adm  3 => Porteiro 4 => Resident
            $table->string('password', 225)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}




