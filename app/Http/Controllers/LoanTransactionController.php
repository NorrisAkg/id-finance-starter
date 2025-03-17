<?php

namespace App\Http\Controllers;

use App\Http\Middleware\OnlyAdmin;
use App\Http\Requests\IncreaseBalanceRequest;
use App\Models\User;
use App\Services\LoanService;
use App\Services\UserService;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class LoanTransactionController extends Controller
{
    public function __construct(protected LoanService $loanService, protected UserService $userService)
    {
        $this->middleware(OnlyAdmin::class);
    }

    public function edit() {
        return Inertia::render('settings/IncreaseBalance', [
            'clients' => $this->userService->getAllUsersExceptAdmin(),
            'flash' => request()->session()->get('flash'),
        ]);
    }

    public function store(IncreaseBalanceRequest $request) {
        $client = User::find($request->client_id);

        $transaction = $this->loanService->makeTransaction($request->validated());
        $this->userService->increaseBalance($client, $request->amount);

        return redirect()->route('transaction.edit')->with('flash', ['success' => 'Solde crédité avec succès.']);
    }
}
