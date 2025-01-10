<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['chat_id', 'sender_id', 'content'];

    // Relación con el modelo Chat
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    // Relación con el usuario (quién envió el mensaje)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
