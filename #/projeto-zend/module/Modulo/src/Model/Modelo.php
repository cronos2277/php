<?php
namespace Modulo\Model;
/*
    Essa eh a classe de modelo seguindo o padrao PSR4
    O TableGateway ira manipular essa classe.
*/
class Modelo{
    private $id;
    private $valor;
    private $dataRegistro;

    public function exchangeArray(array $data){
        $this->id = !empty($data['id'])?$data['id']:null;
        $this->valor = !empty($data['valor'])?$data['valor']:null;
        $this->dataRegistro = !empty($data['dataRegistro'])?$data['dataRegistro']:null;
    }
    public function getId(){
        return $this->id;
    }

    public function getValor(){
        return $this->valor;
    }

    public function getDataRegistro(){
        return $this->dataRegistro;
    }
    public function setId(int $id){
        $this->id = $id;
    }
}