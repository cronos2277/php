# Laravel
## Executando um projeto no laravel
    php artisan serve
## Instalação
Caso de o seguinte erro: 

     Your requirements could not be resolved to an installable set of packages.
        Problem 1
        - laravel/framework[v8.12.0, ..., 8.x-dev] require league/flysystem ^1.1 -> satisfiable by league/flysystem[1.1.0, ..., 1.x-dev].
        - league/flysystem[1.1.0, ..., 1.x-dev] require ext-fileinfo * -> it is missing from your system. Install or enable PHP's fileinfo extension.
        - Root composer.json requires laravel/framework ^8.12 -> satisfiable by laravel/framework[v8.12.0, ..., 8.x-dev].

    To enable extensions, verify that they are enabled in your .ini files:
        - C:\php\php.ini
    You can also run `php --ini` inside terminal to see which files are used by PHP in CLI mode.

Vá até o arquivo `php.ini` e habilite a extensão `php_fileinfo.dll`, da seguinte forma:
Disso: `;extension=fileinfo` para isso `extension=fileinfo`. Geralmente esse arquivo está em *C:\php\php.ini*.