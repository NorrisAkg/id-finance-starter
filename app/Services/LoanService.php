<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Arr;

final class LoanService
{
    public function makeRequest(array $data, User $user): Loan
    {
        /** @var Loan $loan */
        $loan = Loan::make(Arr::except($data, ['user_id']));
        $loan->user()->associate($user);

        $loan->save();

        return $loan;
    }

    public function generateLoanCode(Loan $loan): void
    {
        $loan->update(['code' => rand(10000, 99999)]);
    }

    public function verifyCode(Loan $loan, int $code): bool
    {
        return $loan->code == $code;
    }

    public function getUserLatestPendingLoan(User $user): ?Loan
    {
        // return Loan::where('user_id', $user->id)->where('status', 'pending')->orderBy('id', 'desc')->first();
        return $user->loans()->where('status', 'pending')->orderBy('id', 'desc')->first();
    }

    public function findById(int $id): Loan
    {
        return Loan::findOrFail($id);
    }


    public function updateStatus(int $id, string $status): Loan
    {
        $loan = Loan::findOrFail($id);
        $loan->update(['status' => $status]);

        return $loan;
    }
}
