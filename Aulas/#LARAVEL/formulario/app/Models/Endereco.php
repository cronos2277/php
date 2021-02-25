<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $primaryKey = 'cliente_id';
    use HasFactory;
    function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id','id');
    }
}
