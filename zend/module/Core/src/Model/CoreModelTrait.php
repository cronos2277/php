<?php
namespace Core\Model;
use Zend\Hydrator\Reflection;
trait CoreModelTrait
{
    public function exchangeArray(array $data){
        //Exige o PHP7 para funcionar
        (new Reflection())->hydrate($data, $this);
    }
    public function getArrayCopy(){
        //Exige o PHP7 para funcionar
        return(new Reflection())->extract($this);
    }
}