<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class EnderecoSeeder extends Seeder
{   
    public function run()
    {
        DB::insert('insert into enderecos (cliente_id, estado, cidade, rua) values (?,?,?,?)', [1, 'PR','Curitiba', 'rua 12']);
        DB::insert('insert into enderecos (cliente_id, estado, cidade, rua) values (?,?,?,?)', [2, 'SP','São Paulo', 'rua 15']);
        DB::insert('insert into enderecos (cliente_id, estado, cidade, rua) values (?,?,?,?)', [3, 'MG','Belo Horizonte', 'rua 22']);
        DB::insert('insert into enderecos (cliente_id, estado, cidade, rua) values (?,?,?,?)', [4, 'SC','Joinville', 'rua 19']);
        DB::insert('insert into enderecos (cliente_id, estado, cidade, rua) values (?,?,?,?)', [5, 'RS','Porto Alegre','rua 25']);
    }
}
