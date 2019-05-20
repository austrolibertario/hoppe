<?php

namespace App\Phphub\Listeners;

interface UserCreatorListener
{
    public function userValidationError($errors);
    public function userCreated($user);
}
