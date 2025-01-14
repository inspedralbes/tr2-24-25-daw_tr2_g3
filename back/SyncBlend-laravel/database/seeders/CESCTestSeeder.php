<?php

namespace Database\Seeders;

use app\Helpers\GeneralHelper;
use App\Models\Group;
use App\Models\GroupMemeber;
use App\Models\User;
use App\Services\CESCWizardDefaultService;
use Illuminate\Database\Seeder;

class CESCTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //creating group
        $group = new Group();
        $group->id_parent = 0;
        $group->course = "1";
        $group->letter = "Z";
        $group->save();

        $group->code = GeneralHelper::generateCode('GR', $group->id);
        $group->save();

        //creating users for group
        $user = new User();
        $user->name = "JUAN";
        $user->lastname = "PINTO";
        $user->email = "juan@gmail.com";
        $user->photo_pic = 'https://cdn-icons-png.flaticon.com/512/4792/4792929.png';
        $user->password = bcrypt("contraseña");
        $user->type_document = "dni";
        $user->id_document = "1222222F";
        $user->birthdate = "1990-01-01";
        $user->save();

        $group_members = new GroupMemeber();
        $group_members->group_id = $group->id;
        $group_members->user_id = $user->id;
        $group_members->role = 'student';
        $group_members->save();

        $user2 = new User();
        $user2->name = "PEPE";
        $user2->lastname = "CRESPO";
        $user2->email = "pepe@gmail.com";
        $user->photo_pic = 'https://cdn-icons-png.flaticon.com/512/4792/4792929.png';
        $user2->password = bcrypt("contraseña");
        $user2->type_document = "dni";
        $user2->id_document = "1222223F";
        $user2->birthdate = "1990-01-01";
        $user2->save();

        $group_members = new GroupMemeber();
        $group_members->group_id = $group->id;
        $group_members->user_id = $user2->id;
        $group_members->role = 'student';
        $group_members->save();

        $user3 = new User();
        $user3->name = "KEVIN";
        $user3->lastname = "ALBERTO";
        $user3->email = "kevin@gmail.com";
        $user->photo_pic = 'https://cdn-icons-png.flaticon.com/512/4792/4792929.png';
        $user3->password = bcrypt("contraseña");
        $user3->type_document = "dni";
        $user3->id_document = "1222233F";
        $user3->birthdate = "1990-01-01";
        $user3->save();

        $group_members = new GroupMemeber();
        $group_members->group_id = $group->id;
        $group_members->user_id = $user3->id;
        $group_members->role = 'student';
        $group_members->save();

        $user4 = new User();
        $user4->name = "TETE";
        $user4->lastname = "PEPE";
        $user4->email = "tete@gmail.com";
        $user->photo_pic = 'https://cdn-icons-png.flaticon.com/512/4792/4792929.png';
        $user4->password = bcrypt("contraseña");
        $user4->type_document = "dni";
        $user4->id_document = "1422233F";
        $user4->birthdate = "1990-01-01";
        $user4->save();

        $group_members = new GroupMemeber();
        $group_members->group_id = $group->id;
        $group_members->user_id = $user4->id;
        $group_members->role = 'student';
        $group_members->save();

        //creating default wizard cesc
        $cescDefaultWizard = new CESCWizardDefaultService();
        $cescDefaultWizard->creatFormCESC($group->id);
    }
}
