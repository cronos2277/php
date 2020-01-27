<?php
/*
    Essa é a função de autoload detalhe que apesar do require,
    esse metodo só sera invocado quando for requerido uma classe,
    ou seja o arquivo é carregado, mas a função em si só executa
    quando é requerido algum objeto.
*/
//Essa é a assinatura, o parametro em questão é a classe, quando for instanciar.
function __autoload($classname)
{
    //se existir, importe...
    if(file_exists('public/'.$classname.'.php'))
    {
        require_once 'public/'.$classname.'.php';
    }
}
