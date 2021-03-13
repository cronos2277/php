<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(FormularioSeeder::class);  
        $this->call(ClienteSeeder::class);
        $this->call(EnderecoSeeder::class);  
        $this->call(CategoriaSeeder::class);
        $this->call(ProdutoSeeder::class);      
        $this->call(MotoristaSeeder::class);      
        $this->call(VeiculoSeeder::class);      
        $this->call(UsoMotoristaVeiculoSeeder::class);      
    }
}
