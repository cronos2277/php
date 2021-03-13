<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MotoristaSeeder extends Seeder
{
    public function run()
    {
        DB::insert('insert into motoristas (nome,cpf) values (?, ?)', ['Joao', '123.456.798.11']);
        DB::insert('insert into motoristas (nome,cpf) values (?, ?)', ['Maria', '456.123.798.49']);
        DB::insert('insert into motoristas (nome,cpf) values (?, ?)', ['Lucas', '135.791.246.72']);
        DB::insert('insert into motoristas (nome,cpf) values (?, ?)', ['Luiza', '659.423.811.35']);
        DB::insert('insert into motoristas (nome,cpf) values (?, ?)', ['Ana', '156.421.989.68']);
    }
}
