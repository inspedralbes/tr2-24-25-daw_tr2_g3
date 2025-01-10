<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatUser extends Pivot
{
    use HasFactory;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'chat_id', 
        'user_id', 
        'status',  // Campo que indica el estado (online/offline)
    ];

    // Definir la relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Definir la relación con el modelo Chat
    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
}
