<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Modelos extends Migration
{
    public function up()
    {
        Schema::create('modelos', function (Blueprint $table) {
            $table->id();
            $table->string('Valor')->unique();
            $table->double('numero');
            $table->date('data')->nullable();
            $table->boolean('check')->default(true);
            $table->rememberToken();
            $table->timestamps();            
            $table->softDeletes();
        });   
    }

    
    public function down()
    {
        Schema::dropIfExists('modelos');
    }
}
