<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Exemplo1 extends Migration
{
    /**
     * Execute as migrações.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exemplo', function (Blueprint $table) {
            $table->id();
            $table->string('Valor')->unique();
            $table->double('numero');
            $table->date('data')->nullable();
            $table->boolean('check')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        

    }

    /**
     * Reverta as migrações.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exemplo');
    }
}
