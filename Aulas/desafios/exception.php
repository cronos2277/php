<?php
namespace Excessao;

use DivisionByZeroError;

class Desafio extends \Exception{
    public function __construct($mensagem, $codigo = 0, $erroAnterior = null){
        parent::__construct($mensagem,$codigo,$erroAnterior);
    }
}

function intdiv($a,$b){
    try{  
        echo "\n";
        $resultado = $a/$b;
        if(is_int($resultado)){
            echo "Resultado: ",$resultado;
            return $resultado;
        }else{
            throw new Desafio("A divisao nao resultou em um numero inteiro");
        }
    }catch(DivisionByZeroError $zero){    
        echo "Erro: ",$zero->getMessage();
    }catch(Desafio $d){ 
        echo "Erro: ",$d->getMessage();
        return INF;
    }
}

intdiv(8,2);
intdiv(8,3);
//intdiv(8,0);
//echo \intdiv(8,3);
