<?php

/*
	Namespace é uma divisão lógica no PHP, para evitar conflitos, veja que no exemplo abaixo 2 classes tem o mesmo nome,
	dai para evitar isso o namespace ajudaa saber a qual classe Pessoa se trata, ao ter um namespace no arquivo, todo o 
	código deve ser executado dentro de um bloco namespace. Aqui tem 3 namespaces, ou seja 3 separação lógica.
*/

namespace fisico{
	class Pessoa{
		private $nome;
		private $idade;
		//Construtor, executado na hora de instanciar.
		public function __construct(){ 
			echo "Pessoa fisica criado";
		}
		public function setNome($nome){
			$this->nome = $nome;
		}
		public function setIdade($idade){
			$this->idade = $idade;
		}

		public function getNome(){
			return $this->nome;
		}
		public function getIdade(){
			return $this->idade;
		}
		//destrutor, executado quando o objeto sai da memória.
		public function __destruct(){ 
			echo "Fim da pessoa fisica";
		}
		public function __clone(){
			echo "Você clonou a Pessoa";
		}
	}
}

namespace juridico{
interface juridico{
	public function setMarca($marca);
	public function getMarca();
}

	class Pessoa implements juridico{
		private $marca;
		public function setMarca($marca){
			$this->marca = $marca;
		}
		public function getMarca(){
			return $this->marca;
		}
		//esse método mágico ocorre quando se clona um objeto.
		public function __clone(){ 
			echo "Empresa clonada!<br>";
		}
		public function __construct(){
			echo "Empresa criada<br>";
		}
		public function __destruct(){
			echo "Empresa fechada<br>";
		}

	}
}
namespace executa{
class ProvocarErros{
	public static function erro($mensagem,$codigo){
		//Throw provoca um erro, ele aceita como parametro uma string e um inteiro para código.
		throw new Exception($mensagem,$codigo); 
	}
}

	//Criando um apelido para a classe, informando o namespace e a classe
	use \fisico\Pessoa as Apelido; 
	use \juridico\Pessoa as Empresa;

$empresa = new Empresa(); //Empresa alias da Classe Pessoa
$empresa->setMarca('MInha empresa');
$empresa2 = clone $empresa; //clonando objeto, criando um novo e que não referencia ao original.
$pessoa = new Apelido(); //Apelido alias da Classe Pessoa
$pessoa2 = $pessoa;
$pessoa2->setNome('Joao');
$pessoa2->setidade(21);
echo "Pessoa Nome: ".$pessoa->getNome();
echo "<br>Pessoa idade: ".$pessoa->getIdade();
echo "<br>";
echo "Ta Funfando!<br>Mostrando erro controlado;";
	try{
		//ProvocarErros::erro('Meu erro',1);
	}catch(Exception $e){
		echo "<br>Mensagem do erro: ".$e.getMessage();
		echo "<br>Codigo do erro: ".$e.getCode();
		echo "<br>A linha aonde o erro ocorre: ".$e.getLine();
		echo "<br>O arquivo aonde ocorre: ".$e.getFile();
	}
}
?>
