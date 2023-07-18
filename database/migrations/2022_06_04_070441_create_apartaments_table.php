<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartaments', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('apartament', 180)->nullable();
            $table->text('notes')->nullable();
            $table->enum('occupation', ['0', '1'])->default('0'); // 0 => livre, 1 => ocupado
            $table->integer('typology_id')->nullable();
            $table->integer('building_id')->nullable();
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
        Schema::dropIfExists('apartaments');
    }
}
