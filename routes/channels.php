<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
//rota é o id do user
//1º parâmetro o userAutenticado Laravel faz automático
//2º parâmetro é da URL dinâmica do canal que você está tentando assinar no front-end.
Broadcast::channel('admins', function ($user) {
    return $user->isAdmin();
});
