<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run()
    {              
        DB::table('categorias')->insert(['nome' => 'ROUPAS']);        
        DB::table('categorias')->insert(['nome' => 'ELETRONICO']);
        DB::table('categorias')->insert(['nome' => 'PERFUME']);
        DB::table('categorias')->insert(['nome' => 'MOVEIS']);
    }
}
