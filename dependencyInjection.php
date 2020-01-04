<?php
class Injection{
    private $mensagem = "Um exemplo de como funciona o Dependency Injection";
    function __destruct(){
        echo $this->mensagem;
    }
}

    class Dependency{
        private $instancia;
        function __construct(Injection $instancia){
            $this->instancia = $instancia;
        }

        function __get($param){
            return $this->instancia;
        }
        function __set($nome,$value){
            $this->instancia = $value;
        }
    }
    $injecao = new Injection();
    $resultado = new Dependency($injecao);

    /*
        Nesse padrao de projeto que eh a Injecao de dependencias (Dependencies Injection),
        ao inves da classe conter a instancia de um objeto dentro
        dela, a mesma pode ser passada de alguma forma.
        Repare na Classe Dependency, ela tem um atributo que 
        eh usado nela, no caso o nome do atributo se chama instancia,
        e quando instanciado o objeto de Dependency, a classe
        exige que seja passado esse objeto na hora da instanciacao,
        no caso um objeto do tipo Injection.
        Nesse padrao, a classe consegue as instancias de uma outra
        classe sem precisar instanciar elas, ao inves disso ela
        recebe como parametro um objeto e o usa como um atributo,
        posteriormente, esse eh o principio da injecao de independencia.
    */
?>