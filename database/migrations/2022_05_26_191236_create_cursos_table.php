<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->tinyInteger('estado')->dafault(0);
            $table->date('fecha')->nullable();
            $table->tinyInteger('horas')->nullable();
            // $table->unsignedBigInteger('id_institucion')->nullable(); // no tenemos fuente de datos aun
            // $table->foreign('id_institucion')->references('id')->on('instituciones');
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
        Schema::dropIfExists('cursos');
    }
}
