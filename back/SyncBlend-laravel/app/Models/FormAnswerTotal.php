<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormAnswerTotal extends Model
{
    //

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
