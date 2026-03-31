<?php

namespace App\Http\Services;
use App\Models\User;
use Exception;
use PhpParser\Node\Expr\Cast\Void_;

class UserService
{
    /**
     * @throws Exception
     */
    public function update(array $data, User $user): User
    {
        if (!$user->update($data)) {
            throw new Exception('Error updating user', 500);
        }
        return $user;
    }

    /**
     * @throws Exception
     */
    public function destroy(User $user): Void
    {
        if (!$user->delete()) {
            throw new Exception('Error deleting user', 500);
        }
    }
}
