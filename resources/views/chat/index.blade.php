@extends('layouts.app')
@section('content')
<div class="container mx-auto max-w-4xl p-4 bg-gray-100 min-h-screen flex">
    <!-- Sidebar de usuarios -->
    <div class="w-1/3 bg-white p-4 rounded-lg shadow-md overflow-y-auto h-[500px]">
        <h2 class="text-2xl font-semibold mb-4 text-center">Chat</h2>
        <h3 class="text-lg font-semibold mb-3">Usuarios</h3>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('chat.index') }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-200">
                    <svg width="20" height="20" fill="currentColor" class="text-gray-600">
                        <circle cx="10" cy="10" r="8" stroke="black" stroke-width="1" fill="gray" />
                    </svg>
                    <span>Chat Global</span>
                </a>
            </li>
            @foreach (App\Models\User::where('id', '!=', auth()->id())->get() as $user)
                <li>
                    <a href="{{ route('chat.user', $user->id) }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-200">
                        <svg width="20" height="20" fill="currentColor" class="text-blue-500">
                            <circle cx="10" cy="10" r="8" stroke="black" stroke-width="1" fill="blue" />
                        </svg>
                        <span>{{ $user->name }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    
    <!-- Área de chat -->
    <div class="w-2/3 flex flex-col ml-4">
        
        <div class=" bg-white p-4 rounded-lg shadow-md overflow-y-auto h-[450px]" id="contanier_messages">
            <ul class="space-y-3" id="messages-list">
                @foreach ($messages as $message)
                    <li class="flex items-end @if($message->sender->id === auth()->id()) justify-end @else justify-start @endif">
                        <div class="p-3 max-w-xs rounded-lg shadow-md @if($message->sender->id === auth()->id()) bg-blue-500 text-white @else bg-gray-300 text-black @endif">
                            <strong class="block text-sm">{{ $message->sender->name }}</strong>
                            <p class="text-sm">{{ $message->message }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        
        <form method="POST" action="{{ route('chat.send') }}" class="bg-white p-4 rounded-lg shadow-md flex items-center gap-3 mt-3">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ isset($receiver) ? $receiver->id : '' }}">
            
            <textarea name="message" required class="w-full p-2 border rounded-lg resize-none" placeholder="Escribe un mensaje..." rows="2"></textarea>
            
            <button type="submit" class="bg-blue-500 text-white p-3 rounded-full flex items-center justify-center hover:bg-blue-600">
                <svg width="20" height="20" fill="currentColor" class="text-white">
                    <polygon points="5,3 19,10 5,17" fill="white" />
                </svg>
            </button>
        </form>

        <script>
     document.addEventListener('DOMContentLoaded', function () {
    // Reemplaza esto con el ID del usuario autenticado
    const userId = @json(auth()->id());
   const contanier_messages = document.getElementById('contanier_messages');
   contanier_messages.scrollTop = contanier_messages.scrollHeight;
    window.Echo.private('chat.' + userId)
        .listen('MessageSent', (event) => {
            const message = event.message;
            console.log(event.message);
            
            const messagesList = document.querySelector('#messages-list'); // Asegúrate de que este es el contenedor de mensajes
            const messageElement = document.createElement('li');
            messageElement.classList.add('flex', 'items-end', message.sender_id === userId ? 'justify-end' : 'justify-start');
            messageElement.innerHTML = `
                <div class="p-3 max-w-xs rounded-lg shadow-md ${message.sender_id === userId ? 'bg-blue-500 text-white' : 'bg-gray-300 text-black'}">
                    <strong class="block text-sm">${message.sender.name}</strong>
                    <p class="text-sm">${message.message}</p>
                </div>
            `;
            messagesList.appendChild(messageElement);
            contanier_messages.scrollTop = messagesList.scrollHeight; // Desplazar hacia abajo
        });

        window.Echo.channel('chat.global')
        .listen('MessageSent', (event) => {
            console.log(event.message);
            @if(!isset($message_gobal))
                return ; 
            @endif
            const message = event.message;
            const messagesList = document.querySelector('#messages-list'); // Asegúrate de que este es el contenedor de mensajes
            const messageElement = document.createElement('li');
            messageElement.classList.add('flex', 'items-end');
            messageElement.innerHTML = `
                <div class="p-3 max-w-xs rounded-lg shadow-md ${message.sender_id === event.message.sender_id ? 'bg-blue-500 text-white' : 'bg-gray-300 text-black'}">
                    <strong class="block text-sm">${message.sender.name}</strong>
                    <p class="text-sm">${message.message}</p>
                </div>
            `;
            messagesList.appendChild(messageElement);
            contanier_messages.scrollTop = contanier_messages.scrollHeight; // Desplazar hacia abajo
            const isAtBottom = contanier_messages.scrollHeight - messagesList.clientHeight <= messagesList.scrollTop + 1;
            if (isAtBottom) {
                contanier_messages.scrollTop = contanier_messages.scrollHeight;
            }
        });
});



        </script>
        
    </div>
</div>
@endsection