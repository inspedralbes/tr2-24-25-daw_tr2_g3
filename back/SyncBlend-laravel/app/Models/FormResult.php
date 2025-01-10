<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormResult extends Model
{
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
