<?php
//Lembre-se sempre de seguir o padrao PSR4 para o Zend 3.
namespace Modulo;
//Interface para que as rotas funcionem bem.
use Zend\ModuleManager\Feature\ConfigProviderInterface;
//Nao precisa implementar essa interface ou pode implementar outra,
//mas o nome da classe dentro desse arquivo deve ser esse e o metodo
//getConfig deve existir, para o funcionamento das rotas, esse eh um
//padrao exigido pelo zend, criar um arquivo module, dentro do src, 
//que esta dentro do seu modulo chamado Module.php e dentro desse 
//arquivo criar essa classe.
class Module implements ConfigProviderInterface{
    public function getConfig(){
        //Esse metodo eh obrigatorio, ele dara um include, 
        //no arquivo de rotas, o 'module.config.php' na pasta
        //config. Caso voce precise implementar a Interface,
        //ela exige esse metodo, que deve ter esse retorno. 
        return include __DIR__."/../config/module.config.php";
    }
}

/*
Esse arquivo eh criado de modo que o Zend saiba que aqui eh o diretorio
do modulo, Eh importante que exista esse arquivo.
 */
