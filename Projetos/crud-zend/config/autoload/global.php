<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'db' =>[
        'driver' => 'Pdo_Mysql',
        'host' => '127.0.0.1',
        'database' => 'zf3_helpdesk',
        'username' => 'root',
        'password' => '123456'
    ],
    'mail' =>[
        'name' => 'smtp.mailtrap.io', //SMTP do servidor de e-mail
        'host' => 'smtp.mailtrap.io', //No google so repetir o SMTP
        'port' => 2525, //Porta do servidor do gmail 465.
        'connection_class' => 'login', //diz que sera feito autenticacao para disparar emails
        'connection_config' => array(
            'from' => 'cronos2277-a3e2b0@inbox.mailtrap.io', //Remetente
            'username' => '3e972b27046065', //Email de autenticacao
            'password' => '6d872d256045da', //Senha autenticacao.
            //'ssl' => 'ssl' //Tipo de envio SSL para Gmail.
            'auth' => 'CRAM-MD5', //Forma de criptografia
        ),
    ]
];
/**
 * Aqui fica toda as configuracoes no ambiente de producao, ou seja
 * no projeto que vai ao cliente final.
 */
