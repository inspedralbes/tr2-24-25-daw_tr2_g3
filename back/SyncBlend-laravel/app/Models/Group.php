<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    public function members(){
        return $this->belongsToMany(GroupMemeber::class, 'group_members', 'group_id', 'user_id');
    }
}
