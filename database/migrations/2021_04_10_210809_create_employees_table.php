<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_department');
            $table->string('name', 255);
            $table->string('position', 100);
            $table->decimal('salary', 8, 2)->unsigned();
            $table->date('hiring_date');
            $table->unsignedSmallInteger('status')->default(1);
            $table->foreign('id_department')->references('id')->on('departments')->onDelete('no action')->onUpdate('no action');
            $table->softDeletes();
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
        Schema::dropIfExists('employees');
    }
}
