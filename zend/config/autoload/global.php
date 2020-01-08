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
    ]
];
/**
 * Aqui fica toda as configuracoes no ambiente de producao, ou seja
 * no projeto que vai ao cliente final.
 */
