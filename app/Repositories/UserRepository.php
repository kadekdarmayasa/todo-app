<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Class UserRepository
 * User repository class that handles user-related data operations.
 *
 * @package App\Repositories
 */

class UserRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
