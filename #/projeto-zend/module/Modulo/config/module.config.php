<?php
namespace Modulo;
return [
    //aqui dentro fica as configuracoes.
    /* 
        O router serve para configurar as rotas, ou seja qual classe
    sera executado de acordo com a URL informado. As configuracoes 
    gerais de rotas ficam na pasta config, dentro aqui do eskeleton,
    sendo essa executada por primeiro e depois sao executados as rotas
    dos modulos, como esse por exemplo, mesclando-os. Aqui sera configurado
    as rotas, dentro desse array com o indice router.
    */
    'router' =>[ //opcoes gerais.
        'routes' => [ //definicao de todas as rotas.
            'modulo' => [ //Aqui a definicao da rota modulo.
                /*  Aqui sera criado uma rota do tipo segmento, 
                    que permite voce trabalhar com estruturas de diretorio na url.
                    Repare que na configuracao abaixo eh chamado a classe, 
                    ou seja eh usado conceitos de programacao reflexiva.
                    Voce provavelmente pode criar uma classe customizada
                    implementando RouteInterface como a classe Segment faz.
                */
                'type' => \Zend\Router\Http\Segment::class, 
                'options' => [ //Dentro desse array estao as opcoes dessa rota em especifico
                    /*
                        Caso tenha modulo na url do navegador, essa rota sera chamada.
                    Tudo o que esta dentro dos colchetes eh opcional e o dois pontos
                    serao os atributos a serem substituidos, resumindo esses diretorios
                    abaixo iram ativar essa rota.
                    www.seudominio/modulo
                    www.seudominio/modulo/listar
                    www.seudominio/modulo/consultar/
                    www.seudominio/modulo/listar/2 
                    repare que o listar, assim como o 2 na url eh possivel apenas
                    em funcao dos colchetes, pois o que importa aqui para ativar essa rota
                    eh ter modulo na url, logo apos o dominio.
                    */
                    'route' => '/modulo[/:action[/:id]]',
                    /* 
                        Aqui voce limita o formato da url, a fim de evitar Code injection
                     por exemplo via GET. Ou seja que a url seja valida, a mesma precisa
                     obedecer os criterios aqui definidos.
                     */
                    'constraints' => [ 
                    //A Expressao regular abaixo apenas permite Letra, numeros, hifem e underline.    
                    //Qualquer outra caracter diferente desses na url, a rota sera recusada, 
                    //evitando-se assim um code injection via URL.
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        //Aqui eh delimitado os valores do /:id na route, no caso apenas numeros
                        'id' => '[0-9]+'
                    ],
                    //Aqui eh definido as acoes padroes da URL, ou seja caso a url seja
                    //validado pela constraints mas nao se aplica as excecoes especificadas.
                    'defaults' => [
                        //O controlador => \Namespace\Classe
                        'controller' => Controller\ModuloController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    //Aqui sera configurado, aonde estao as nossa Views.
    'view_manager' => [
        //Nesse array abaixo tem diversas configuracoes.
        'template_path_stack' => [
            //Aqui o caminho do seu view, no caso eh informado a raiz do modulo, view.
            'modulo' => __DIR__.'/../view/',
        ]
    ]
];
/*
    Esse e um arquivo de configuracao dentro do modulo, 
    todas as configutacoes devem ficar nesse arquivo.
    O Zend ele pega todos esses arquivos dos modulos e une tudo dentro do
    index.php la no diretorio public. Todo projeto segue o padrao PSR4.
    Todas as configuracoes no zend sao baseados em arrays, 
    contendo chave e valor.
*/