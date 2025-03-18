<?php

namespace App\Services;

use App\Models\LoanTransaction;
use App\Models\User;
use Illuminate\Support\Collection;

class UserService
{
    public function getAllUsersExceptAdmin(): Collection
    {
        // Récupérer les utilisateurs qui ont au moins un transfert
        return User::where('is_admin', false)->get();
    }

    public function alterBalance(User $user, float $amount, string $type): void
    {
        $user->balance = $type == 'deposit' ? $user->balance + $amount : $user->balance - $amount;
        $user->save();
    }

    public function getTransactions(User $user): Collection
    {
        return LoanTransaction::where('client_id', $user->id)->get();
    }
}
