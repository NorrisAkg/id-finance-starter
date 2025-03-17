<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class UserService
{
    public function getAllUsersExceptAdmin(): Collection
    {
        // Récupérer les utilisateurs qui ont au moins un prêt
        return User::where('is_admin', false)->get();
    }

    public function increaseBalance(User $user, float $amount): void
    {
        $user->balance += $amount;
        $user->save();
    }
}
