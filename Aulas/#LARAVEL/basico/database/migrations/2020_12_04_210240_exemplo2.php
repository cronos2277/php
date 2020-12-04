<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Exemplo2 extends Migration
{

    public function up()
    {
        Schema::create('exemplo2', function (Blueprint $table) {                                  
            $table->bigIncrements('id');
            $table->foreignId('fk');

            $table
            ->foreign('fk')
            ->references('id')
            ->on('exemplo')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::table('exemplo2', function (Blueprint $table) {
            $table->dropForeign(['fk']);
        });
        Schema::drop('exemplo2');
    }
}
