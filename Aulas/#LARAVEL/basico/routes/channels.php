<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Canais de transmissão
|--------------------------------------------------------------------------
|
| Aqui você pode cadastrar todos os canais de transmissão de eventos que o seu
| Suportes de aplicativos. Os retornos de chamada de autorização de canal fornecidos são
| usado para verificar se um usuário autenticado pode ouvir o canal.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
