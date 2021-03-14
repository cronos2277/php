<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsoMotoristaVeiculo extends Model
{
    protected $table = "uso_motorista_veiculos";
    protected $primaryKey = ["veiculo_id","motorista_id"];
    
    use HasFactory;    
    
}
