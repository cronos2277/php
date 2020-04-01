<?php
class MinhaData{
    private int $dia = 01;
    private int $mes = 01;
    private int $ano = 1970;

    public function adicionarDia(int $dia = 1){
        $this->dia = $dia;
    }

    public function adicionarMes(int $mes = 1){
        $this->mes = $mes;
    }

    public function adicionarAno(int $ano = 1970){
        $this->ano = $ano;
    }

    public function exibirData(){
        return $this->dia."/".$this->mes."/".$this->ano;
    }
    
}

$minhaData = new MinhaData();
echo $minhaData->exibirData();
$minhaData->adicionarDia(31);
$minhaData->adicionarMes(03);
$minhaData->adicionarAno(2020);
echo "\n".$minhaData->exibirData();