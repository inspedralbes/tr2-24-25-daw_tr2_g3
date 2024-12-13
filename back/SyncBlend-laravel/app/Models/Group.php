<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    //
    public function members(){
        //return $this->belongsToMany(User::class, 'group_memebers', 'group_id', 'user_id')->where('role', 'student');
        return $this->HasMany(GroupMemeber::class, 'group_id',)->where('role', 'student');
    }

    public static function getLetters($table, $column){
        $type = DB::select("SHOW COLUMNS FROM $table  WHERE Field = ?", [$column])[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();

        foreach (explode(',',$matches[1]) as $match) {
            $enum[] = trim($match, "'");
        }
        return $enum;
    }

}
