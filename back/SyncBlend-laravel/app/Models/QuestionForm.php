<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionForm extends Model
{
    use HasFactory;

    protected $table = 'question_forms';

    protected $fillable = ['idQuestion', 'idForm'];

    public function getQuestion()
    {
        return $this->belongsTo(Questions::class, 'id');
    }
}
