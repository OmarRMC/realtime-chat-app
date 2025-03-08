<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
// Si es privado el canal se tiene que  definir las reglas de acceso
Broadcast::channel('chat.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId; // Solo permite que el usuario acceda a su propio canal
});

Broadcast::channel('chat.global', function ($user) {
    return true; // Permitimos que cualquier usuario se suscriba al canal global
});

// Broadcast::channel('canal-mensajes', function ($user) {
//     return true; // Permitir a todos los usuarios autenticados
// });