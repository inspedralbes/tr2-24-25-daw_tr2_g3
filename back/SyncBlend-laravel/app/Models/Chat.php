<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['lastMessage'];

    // Relación con los usuarios
    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_user', 'chat_id', 'user_id');
    }

    // Relación con los mensajes
    public function messages()
    {
        return $this->hasMany(Message::class);  // Un chat puede tener muchos mensajes
    }

    // Relación para obtener el último mensaje
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latest();  // El mensaje más reciente
    }
}

