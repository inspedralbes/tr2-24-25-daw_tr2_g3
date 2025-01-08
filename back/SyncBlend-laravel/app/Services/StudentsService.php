<?php

namespace App\Services;

use App\Models\GroupMemeber;

class StudentsService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createStudent($group, $user)
    {
        $newGroupMember = new GroupMemeber();
        $newGroupMember->group_id = $group->id;
        $newGroupMember->user_id = $user->id;
        $newGroupMember->role = 'student';
        $newGroupMember->save();

        return $newGroupMember;
    }

    public function checkIfExistsInGroup($group, $user)
    {
        return GroupMemeber::where('group_id', $group->id)->where('user_id', $user->id)->where('role', 'student')->first();
    }

}
