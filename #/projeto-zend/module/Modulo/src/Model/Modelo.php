<?php
namespace Modulo\Model;
/*
    Essa eh a classe de modelo seguindo o padrao PSR4
    O TableGateway ira manipular essa classe.
*/
use Zend\Stdlib\ArraySerializableInterface;
class Modelo implements ArraySerializableInterface{
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
    public function setValor($valor){
        $this->valor = $valor;
    }
    public function setDataRegistro($data){
        $this->dataRegistro = $data;
    }
    public function getArrayCopy():array{
        return[
            'id' => $this->id,
            'valor' => $this->valor,
            'dataRegistro' => $this->dataRegistro
        ];

    }
}