<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    
    public function run()
    {
        DB::insert('insert into produtos (estoque,nome) values (?, ?)', [5, 'Camisa Polo']);
        DB::insert('insert into produtos (estoque,nome) values (?, ?)', [2, 'Televisor']);
        DB::insert('insert into produtos (estoque,nome) values (?, ?)', [1, 'Perfume feminino']);
        DB::insert('insert into produtos (estoque,nome) values (?, ?)', [4, 'Sofa de canto']);
    }
}
