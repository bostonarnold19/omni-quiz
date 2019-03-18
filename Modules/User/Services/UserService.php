<?php

namespace Modules\User\Services;

use Modules\User\Interfaces\UserRepositoryInterface;

class UserService
{
    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }
}
