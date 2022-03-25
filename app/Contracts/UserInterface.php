<?php

namespace App\Contracts;

use App\Models\User;

interface UserInterface
{
    /**
     * store user.
     *
     * @param array $storeUserData
     * @return User
     */
    public function store(array $storeUserData) : User;


}
