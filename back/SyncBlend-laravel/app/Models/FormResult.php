<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormResult extends Model
{
    use HasFactory;

    // Agregar los campos permitidos para asignación masiva
    protected $fillable = [
        'user_id',
        'form_id',
        'group_id',
        // Añade más campos según sea necesario
    ];
    //
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
