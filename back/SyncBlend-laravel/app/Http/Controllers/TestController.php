<?php

namespace App\Http\Controllers;

use app\Helpers\GeneralHelper;
use App\Models\Form;
use App\Models\Group;
use App\Models\QuestionForm;
use App\Models\Questions;
use App\Services\CESCWizardDefaultService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function test()
    {
        $groups = Group::all();

        foreach ($groups as $group) {
            $formsGroup = $group->getForms;

            $exists = false;
            foreach ($formsGroup as $form) {
                if($form->slug === 'cesc-form-eso'){
                    $exists = true;
                }
            }
            if(!$exists){
                $cesc = new CESCWizardDefaultService();
                $cesc->creatFormCESC($group->id);
            }
        }

        return "ok";
    }

}
