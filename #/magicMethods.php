<?php
namespace MagicTest;
class Magic{
	private $data;
	//chamado quando tenta atribuir valor a um atributo que não existe na classe, tem como parâmetro o primeiro referenciando ao nome atributo e o segundo o valor: 
	//Exemplo $object->attr = novoValor; a $variavel se refere nesse exemplo o attr e o $valor ao novoValor.
	public function __set($variavel, $valor){ 
		throw new Exception('Action Forbidden!',50);
	}
	//Chamado quando se tenta resgatar um atributo que não tem na classe, ele requer um atributo que referencia ao nome. no caso de um $object->meuAttr, ele vale ao meuAttr.
	public function __get($variavel){
		throw new Exception("Action Forbidden!",50);
	}
	//O comportamento quando o objeto é tratado como uma string, por exemplo: "echo $objeto", nesse caso é chamado esse método.
	public function __toString(){ 
		return ''.$this->data;
	}
	//O comportamento quando o objeto é tratado como função. por exemplo "objeto()", nesse caso, quando o objeto vira função esse método é chamado.
	public function __invoke($param){ 
		$this->data = $param;
	}
}

$object = new \MagicTest\Magic(); //Instanciando o objeto da classe Magic, passando também o namespace como caminho.
//$object->pessoa = 'ola mundo';
//echo $object->pessoa;
$object('Inserindo dados'); //nesse momento é chamado o __invoke
echo $object; //nesse momento é chamado o __toString

?>
