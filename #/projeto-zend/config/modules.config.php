<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

/**
 * List of enabled modules for this application.
 *
 * This should be an array of module namespaces used in the application.
 */
return [
    'Zend\I18n',
    'Zend\Form', //Formulario do Zend
    'Zend\InputFilter', //Modulo do zend para sanatizar formularios
    'Zend\Filter',
    'Zend\Hydrator',
    'Zend\Db', //Banco de dados do Zend.
    'Zend\Router', //Rota do Zend.
    'Zend\Validator', //Modulos da Zend.
    'Application', //Esse ja vem por padrao. Serve como exemplo no eskeleton.
    'Modulo', // Esse eh o metodo criado aqui, e aqui eh feito o registro do mesmo
];
/*
    Todos os modulos locais, devem ser registrado aqui. 
    Existe dois modules.config.php, o local configurado em cada modulo
    e este aqui que eh o global, ou seja os modulos devem estar registrados
    aqui para que funcionem, mas uma vez configurado aqui, nao esqueca
    de tambem fazer as configuracoes do composer.json, na parte do autoload
    no PSR4, como eh esse exemplo, apos configurado, nao esqueca do comando
    `composer dump-autoload` para atualizar os loaders do composer, toda vez
     que voce altera isso, se faz necessario executar esse comando, para que o
     composer atualize dentro dos arquivos PHP os novos arquivos a serem carregados.
*/