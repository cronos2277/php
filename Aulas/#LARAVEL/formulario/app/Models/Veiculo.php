<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $table = "veiculos";
    protected $primaryKey = "id";
    
    use HasFactory;

    public function motoristas(){
        return $this->belongsToMany(Motorista::class,UsoMotoristaVeiculo::class)->withPivot('ultimo_uso');
    }
}
