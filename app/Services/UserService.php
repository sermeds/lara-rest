<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function all()
    {
        return User::all();
    }

    public function findOrFail($id)
    {
        return User::findOrFail($id);
    }

    public function createUser(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $data['role'] = User::ROLE_USER;
        $data['date_joined'] = now();
        return User::create($data);
    }

    public function updateUser($id, array $data)
    {
        $user = $this->findOrFail($id);
        return $user->update($data);
    }

    public function deleteUser($id)
    {
        $user = $this->findOrFail($id);
        return $user->delete();
    }
}
