<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;

class TodoPolicy
{
    public function edit(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user->id;
    }

    public function update(User $user, Todo $todo): bool
    {
        return $user->id === $todo->user->id;
    }

    public function delete(User $user, Todo $todo): bool
    {
        return false;
    }

    public function restore(User $user, Todo $todo): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Todo $todo): bool
    {
        return false;
    }
}
