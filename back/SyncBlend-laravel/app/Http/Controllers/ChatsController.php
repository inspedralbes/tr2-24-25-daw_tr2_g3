<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;
use App\Models\ChatUser;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    // Buscar o crear un chat
    public function searchOrCreate(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        // Validación del nombre de usuario (username)
        $request->validate([
            'username' => 'required|string',
        ]);

        // 1. Buscar al usuario por nombre
        $user = User::where('name', $request->username)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // 2. Comprobar si existe un chat entre el usuario autenticado y el usuario buscado
        $chat = Chat::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->first();

        // 3. Si no existe el chat, crearlo
        if (!$chat) {
            $chat = Chat::create([
                'lastMessage' => 'New conversation started', // Mensaje inicial
            ]);

            // Asignar los usuarios a este chat (a través de la tabla intermedia 'chat_user')
            $chat->users()->attach([Auth::id(), $user->id]);

            // Create the initial message
            Message::create([
                'chat_id'   => $chat->id,
                'sender_id' => Auth::id(),
                'content'   => 'New conversation started',
            ]);
        }

        // 4. Devolver el chat
        return response()->json($chat);
    }

    // Obtener todos los chats del usuario autenticado
    public function getChats(Request $request)
    {
        // Obtener todos los chats del usuario autenticado
        $chats = Chat::whereHas('users', function ($query) {
            $query->where('user_id', auth()->id());
        })->with(['users', 'lastMessage'])->get();

        // Transformar la respuesta para que coincida con el formato esperado
        $chats = $chats->map(function ($chat) {
            // Suponiendo que el chat tiene una relación con 'users' y 'lastMessage'
            $user = $chat->users->firstWhere('id', '!=', auth()->id());  // Obtener el primer usuario relacionado al chat
            return [
                'id' => $chat->id,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'lastname' => $user->lastname,
                    'avatar' => $user->photo_pic,  // Suponiendo que tienes una columna `photo_pic`
                    'status' => $user->status,  // Suponiendo que tienes una columna `status`
                ],
                'lastMessage' => [
                    'content' => $chat->lastMessage, 
                    'timestamp' => '14:00',
                ],
            ];
        });

        return response()->json($chats);
    }

    // Obtener los mensajes de un chat específico
    public function getMessages($chatId)
    {
        // Verificar si el chat existe
        $chat = Chat::find($chatId);
        if (!$chat) {
            return response()->json(['error' => 'Chat not found'], 404);
        }

        // Obtener los mensajes del chat especificado, ordenados por fecha de creación
        $messages = $chat->messages()->orderBy('created_at', 'asc')->get();

        // Devolver los mensajes
        return response()->json($messages);
    }

    // Método para establecer el estado Online
    public function setStatusOnline(Request $request)
    {
        $chatId = $request->input('chat_id');
        $userId = $request->input('user_id');

        // Buscar la relación ChatUser correspondiente
        $chatUser = ChatUser::where('chat_id', $chatId)
                            ->where('user_id', $userId)
                            ->first();

        if ($chatUser) {
            $chatUser->status = 'Online';
            $chatUser->save();
            return response()->json(['status' => 'Online'], 200);
        }

        return response()->json(['error' => 'User not found in the chat'], 404);
    }

    // Método para establecer el estado Offline
    public function setStatusOffline(Request $request)
    {
        $chatId = $request->input('chat_id');
        $userId = $request->input('user_id');

        // Buscar la relación ChatUser correspondiente
        $chatUser = ChatUser::where('chat_id', $chatId)
                            ->where('user_id', $userId)
                            ->first();

        if ($chatUser) {
            $chatUser->status = 'Offline';
            $chatUser->save();
            return response()->json(['status' => 'Offline'], 200);
        }

        return response()->json(['error' => 'User not found in the chat'], 404);
    }

    // Método para obtener el estado del usuario en un chat
    public function getStatus(Request $request)
    {
        $chatId = $request->input('chat_id');
        $userId = $request->input('user_id');

        // Buscar la relación ChatUser correspondiente
        $chatUser = ChatUser::where('chat_id', $chatId)
                            ->where('user_id', $userId)
                            ->first();

        if ($chatUser) {
            return response()->json(['status' => $chatUser->status], 200);
        }

        return response()->json(['error' => 'User not found in the chat'], 404);
    }
}
