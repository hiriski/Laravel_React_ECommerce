<?php

namespace Modules\User\Utilities;

use Modules\User\Entities\User;

class UserUtility
{
    public static function generateUsername($name)
    {
        if ($name) {
            $username = strtolower(str_replace(' ', '', $name)) . rand(1, 99999);
            if (User::where(['username' => $username])->first()) {
                self::generateUsername($name);
            }
            return $username;
        }
    }
}
