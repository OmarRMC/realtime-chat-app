<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Events\MensajeEnviado;
use App\Events\MessageSent;
use App\Http\Controllers\ChatController;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::middleware('auth')->get('/enviar-mensaje', function (Request $request) {
    //Log::info('Hoola1');
    $user =  $request->user();
    $mensaje = "¡Hola desde Laravel!";

    // event(new MensajeEnviado($mensaje));
    // broadcast(new MensajeEnviado($mensaje));

    //MensajeEnviado::broadcast($user , $mensaje);
    //MensajeEnviado::dispatch($mensaje);
    broadcast(new MensajeEnviado($user, $mensaje))->toOthers();
    //event(new MensajeEnviado($mensaje));
    return view('dashboard');
});

Route::get('/enviar-mensaje1', function (Request $request) {
    //Log::info('Hoola1');
    //$user =  $request->user();
    $user = User::first();
    $mensaje = "¡Hola desde Laravel!";

    // event(new MensajeEnviado($mensaje));
    // broadcast(new MensajeEnviado($mensaje));

    //MensajeEnviado::broadcast($user , $mensaje);
    //MensajeEnviado::dispatch($mensaje);
    broadcast(new MensajeEnviado($user, $mensaje));
    //event(new MensajeEnviado($mensaje));
    return 1;
});

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}', [ChatController::class, 'userChat'])->name('chat.user');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
});
require __DIR__ . '/auth.php';
