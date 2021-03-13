<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class VeiculoSeeder extends Seeder
{
    public function run()
    {
        DB::insert('insert into veiculos (cor,luxo,placa) values (?,?,?)', ['#000000',false,'DDE-4879']);
        DB::insert('insert into veiculos (cor,luxo,placa) values (?,?,?)', ['#00FF00',true,'ZTC-6523']);
        DB::insert('insert into veiculos (cor,luxo,placa) values (?,?,?)', ['#0000FF',false,'IMP-1100']);
        DB::insert('insert into veiculos (cor,luxo,placa) values (?,?,?)', ['#00FFFF',true,'XYZ-0334']);
        DB::insert('insert into veiculos (cor,luxo,placa) values (?,?,?)', ['#FFFFFF',false,'FAC-2882']);
        
    }
}
