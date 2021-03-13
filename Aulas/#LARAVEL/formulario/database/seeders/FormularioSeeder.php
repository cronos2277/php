<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormularioSeeder extends Seeder
{
    public function run()
    {
        $acc1 = [            
            'nome' => 'Matheus',
            'email' => 'matheus@matheus.com',
            'idade' => 20,
            'salario' => 1516.17
        ];

        $acc2 = [            
            'nome' => 'Paula',
            'email' => 'paula@paula.com',
            'idade' => 39,
            'salario' => null
        ];

        $acc3 = [            
            'nome' => 'Francisco',
            'email' => 'francisco@francisco.com',
            'idade' => 44,
            'salario' => 2281
        ];

        $acc4 = [            
            'nome' => 'Fernanda',
            'email' => 'fernanda@fernanda.com',
            'idade' => 18,
            'salario' => 3221.98
        ];

        $acc5 = [            
            'nome' => 'Julio',
            'email' => 'julio@julio.com',
            'idade' => 32,
            'salario' => null
        ];

        DB::table('formularios')->insert($acc1);
        DB::table('formularios')->insert($acc2);
        DB::table('formularios')->insert($acc3);
        DB::table('formularios')->insert($acc4);
        DB::table('formularios')->insert($acc5);
    }
}
