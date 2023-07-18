<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('title', 255)->nullable();
            $table->string('file', 255)->nullable();
            $table->enum('type', ['0', '1', '2', '3'])->default('0');
            $table->integer('resident_id')->nullable();
            $table->text('about')->nullable();
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
        Schema::dropIfExists('documents');
    }
}
