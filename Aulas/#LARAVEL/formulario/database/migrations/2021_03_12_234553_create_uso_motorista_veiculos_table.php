<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsoMotoristaVeiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uso_motorista_veiculos', function (Blueprint $table) {            
            $table->integer('veiculo_id')->unsigned();
            $table->foreign('veiculo_id')->references('id')->on('veiculos');
            $table->integer('motorista_id')->unsigned();
            $table->foreign('motorista_id')->references('id')->on('motoristas');
            $table->date('ultimo_uso')->nullable(true);
            $table->primary(['motorista_id','veiculo_id']);
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
        Schema::dropIfExists('uso_motorista_veiculos');
    }
}
