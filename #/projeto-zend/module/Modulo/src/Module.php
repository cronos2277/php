<?php
//Lembre-se sempre de seguir o padrao PSR4 para o Zend 3.
namespace Modulo;
//Interface para que as rotas funcionem bem.

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
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

    public function getServiceConfig(){
        /*
            Aqui sao feitas as configuracoes para que o 
            TableGateway possa conhecer o Model.
            Nao esqueca que para isso precisa ter o 
            Zend-db instalado, uma vez que o Zend-db
            esteja instalado, ai voce podera usar o
            TableGateway.
        */
        return [ //A funcao getServiceConfig retorna um array contendo as factories.
            /*
                Aqui sao configurado as factories, ou seja
                quando o Zend for instanciar um ModeloTable ele 
                chamara uma funcao construtora e o mesmo vale para 
                o ModeloTableGateway padrao, uma vez criadas ambas
                as classes, aqui nos podemos construir uma funcao
                construtora para ambas. A funcao construtora recebe
                por padrao um parametro chamado $container.
                resumindo, quando o zend for instanciar o
                Mode\Table::class, tera uma funcao associada a
                ela que eh a construtora, assim sendo: 
                Mode\Table::class => function($container){} ou
                Mode\TableGateway::class => function($container){}
                lembrando que como sao funcoes construtoras, se faz
                necessario que a mesma tenha um retorno. Pense nessas
                funcoes como sendo uma __construct das classes, porem
                como o padrao de projeto aqui eh o independency injection
                o reaproveitamento de objetos eh muito melhor.
            */
            'factories' => [ //Repare que o factories eh um array.
//As factories sao um dos elementos retornado pelo array do getServiceConfig, cuidado para nao se perder.                
                Model\ModeloTable::class => function($container){ //Primeiro elemento do array factories.
                    /*
                        Aqui atraves do metodo get, estamos solicitando uma classe, o
                        metodo get aceita uma classe TableGateway como parametro,
                        o objeto que atende a nossa solicitacao eh o $container.
                        Repare que esse container ira chamar a factory logo abaixo
                        que eh a factory da classe ModeloTableGateway. Ou seja,
                        Aqui estamos solicitando ao $container a Classe ModeloTableGatway, 
                        e essa classe ela tambem tem uma factory, que eh a factory do 
                        ModeloTableGateway, essa factory vai executar a funcao construtora
                        dela, depois de executada, sera entregue um
                        objeto ModeloTableGateway, para nos e ai por fim,
                        ele sera usado como parametro para a classe ModeloTable que eh 
                        chamado aqui e por fim retornado. Lembrando que essa factory,
                        retorna um ModeloTable, porem o ModeloTable devido ao 
                        fato de seguir o padrao independency injection necessita
                        de um objeto do tipo ModeloTableGateway como parametro,
                        uma vez feito isso, ai sim pode ser retornado um objeto
                        ModeloTable com o seu devido parametro, atraves do metodo get
                        do objeto $container.
                    */
                    $tableGateway = $container->get(Model\ModeloTableGateway::class);
                    return new Model\ModeloTable($tableGateway); //Aqui eh feito o retorno do ModeloTable.
                },
                Model\ModeloTableGateway::class => function($container){ //Segundo elemento do array factories.
                    /*
                        Agora quando o Zend procurar por uma classe ModeloTableGateway,
                        essa metodo construtor sera executado, no caso isso eh feito,
                        quando a factory anterior eh solicitada, por exemplo.
                        Aqui nas linhas abaixo estamos pedindo uma classe ao container.
                        que executara uma funcao construtora como essa, ou nao.
                    */                    
                    $dbAdapter = $container->get(AdapterInterface::class); 
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Modelo());
                    return new TableGateway('modelo',$dbAdapter,null,$resultSetPrototype);
                },
            ]
        ];
    }
}

/*
Esse arquivo eh criado de modo que o Zend saiba que aqui eh o diretorio
do modulo, Eh importante que exista esse arquivo.
 */
