<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model{
    use HasFactory;

    protected $fillable = ['question', 'answers'];

    protected $casts = [
        'answers' => 'array',
    ];

    public function forms()
    {
        return $this->belongsToMany(Form::class, 'question_forms', 'idQuestion', 'idForm');
    }
}
