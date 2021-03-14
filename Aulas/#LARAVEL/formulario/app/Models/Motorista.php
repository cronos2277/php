<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    protected $table = "motoristas";
    protected $primaryKey = "id";
    
    use HasFactory;

    public function veiculos(){
        return $this->belongsToMany(Veiculo::class,UsoMotoristaVeiculo::class)->withPivot('ultimo_uso');
    }
}
