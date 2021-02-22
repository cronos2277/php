<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Enderecos extends Migration
{
    
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->integer('cliente_id')->unsigned();

            $table->foreign('cliente_id')
            ->references('id')->on('clientes')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->primary('cliente_id');
            $table->string('estado');
            $table->string('cidade');
            $table->string('rua');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::drop('enderecos');
    }
}
