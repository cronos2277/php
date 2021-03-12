<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert('insert into clientes (nome, email) values (?, ?)', ['Joao', 'joao@joao.com']);
        DB::insert('insert into clientes (nome, email) values (?, ?)', ['Maria', 'maria@maria.com']);
        DB::insert('insert into clientes (nome, email) values (?, ?)', ['Lucas', 'lucas@lucas.com']);
        DB::insert('insert into clientes (nome, email) values (?, ?)', ['Luiza', 'luiza@luiza.com']);
        DB::insert('insert into clientes (nome, email) values (?, ?)', ['Ana', 'ana@ana.com']);
    }
}
