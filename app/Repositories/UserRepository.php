<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function find($id): ?User
    {
        return User::find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', strtolower(trim($email)))->first();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update($id, array $data): ?User
    {
        $user = $this->find($id);
        if ($user) {
            $user->update($data);
        }
        return $user;
    }
}

