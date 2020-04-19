<?php
/*
    Dessa forma que você cria uma Exception customizável, todas
    as extensões deve extender de alguma forma da classe "Throwable",
    nesse caso a "Exception" eh uma filha dela. O construtor deve ter
    3 parametros;
    $mensagem => No caso a mensagem que será exibida.
    $codigo => Codigo de erro.
    $erroAnterior => Se tem um erro para interagir com esse.
    Além disso você deve chamar a classe Pai, usando esses parametros 
    acima.
*/
class Exemplo extends Exception{
    public function __construct($mensagem, $codigo = 0, $erroAnterior = null){
        parent::__construct($mensagem,$codigo,$erroAnterior);
    }
}
/*
    Um erro tratado não suspende a execução da Aplicação, o mesmo
    passa pelo finally, independente se passe pelo Try ou catch e 
    continua executando as instruções. Porém um erro não tratado,
    a execução é suspensa.
*/
try{
    throw new Exemplo("Erro personalizavel!");
}catch(Exemplo $exemplo){
    echo $exemplo->getMessage();
}catch(Throwable $oErroMaisGenerico ){
    echo "não cai aqui";
}finally{
    echo "\n";
}
echo "Erro tratado não enterrompe a execucao do PHP.";
/*
    No PHP todas as Classes de erro são filhas de Throwable,
    você precisa extender dela, ou de uma filha dela, para 
    que a exceção seja válida. Se possível segue o padrão
    usado para montar essa exceção que foi criada aqui.
    Três parametros no construtor e a chamada no construtor
    pai no caso.
*/