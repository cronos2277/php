<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsoMotoristaVeiculoSeeder extends Seeder
{
    public function run()
    {
        DB::insert('insert into uso_motorista_veiculos (veiculo_id,motorista_id,ultimo_uso) values (?,?,?)', [1,1,'2021-01-06']);
        DB::insert('insert into uso_motorista_veiculos (veiculo_id,motorista_id,ultimo_uso) values (?,?,?)', [2,2,'2021-02-12']);
        DB::insert('insert into uso_motorista_veiculos (veiculo_id,motorista_id,ultimo_uso) values (?,?,?)', [3,3,'2021-03-29']);
        DB::insert('insert into uso_motorista_veiculos (veiculo_id,motorista_id,ultimo_uso) values (?,?,?)', [4,4,'2021-04-19']);
        DB::insert('insert into uso_motorista_veiculos (veiculo_id,motorista_id,ultimo_uso) values (?,?,?)', [5,5,'2021-05-03']);
    }
}
