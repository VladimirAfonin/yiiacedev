<?php

namespace frontend\services;

use common\models\User;
use frontend\models\SignupForm;

class SignupService
{
    public static function signup(SignupForm $form): User
    {
        $user = User::signup($form->username, $form->email, $form->password);
        if(!$user->save()) throw new \RuntimeException('saving error.');
        return $user;
    }
}