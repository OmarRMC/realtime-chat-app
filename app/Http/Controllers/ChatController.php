<?php

namespace App\Http\Controllers;

use App\Events\MensajeEnviado;
use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index(Request $request)
    {


        $users = User::where('id', '!=', $request->user()->id)->get();
        //$messages = Message::whereNull('receiver_id')->orWhere('receiver_id', $request->user()->id)->get();
        $messages = Message::whereNull('receiver_id')->orderBy('created_at', 'asc')->get();
        $message_gobal = true ; 
        return view('chat.index', compact('users', 'messages', 'message_gobal'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'nullable|exists:users,id',
        ]);


        $message = Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $request->receiver_id, // Puede ser null para mensajes globales
            'message' => $request->message,
        ]);
        $message->sender->name= $request->user()->name;
        //Log::info(['Mensaje enviado: ' => $message]);
        Log::info("Mensaje enviado: ");
        if($request->receiver_id){
            broadcast(new MessageSent($message));
        }else{          
            broadcast(new MessageSent($message))->toOthers();
        }        
        return redirect()->back();
    }

    public function userChat(Request $request, $id)
    {
        $users = User::where('id', '!=', $request->user()->id)->get();
        $receiver = User::findOrFail($id);

        $messages = Message::where(function ($query) use ($id, $request) {
            $query->where('sender_id', $request->user()->id)->where('receiver_id', $id);
        })->orWhere(function ($query) use ($id, $request) {
            $query->where('sender_id', $id)->where('receiver_id', $request->user()->id);
        })->orderBy('created_at', 'asc')->get();

        return view('chat.index', compact('users', 'messages', 'receiver'));
    }
}
