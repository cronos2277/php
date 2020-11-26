<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Este arquivo nos permite emular a funcionalidade "mod_rewrite" do Apache do
// servidor web PHP integrado. Isso fornece uma maneira conveniente de testar um Laravel
// aplicativo sem ter instalado um software de servidor web "real" aqui.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
