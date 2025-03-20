<?php

namespace App\Http\Controllers;

use App\Http\Middleware\OnlyAdmin;
use App\Http\Requests\IncreaseBalanceRequest;
use App\Http\Resources\TransactionResource;
use App\Models\User;
use App\Services\LoanService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class LoanTransactionController extends Controller
{
    public function __construct(protected LoanService $loanService, protected UserService $userService)
    {
        $this->middleware(OnlyAdmin::class)->except('transactionsHistory');
    }

    public function edit()
    {
        return Inertia::render('settings/IncreaseBalance', [
            'clients' => $this->userService->getAllUsersExceptAdmin(),
            'flash' => request()->session()->get('flash'),
        ]);
    }

    public function store(IncreaseBalanceRequest $request)
    {
        $client = User::find($request->client_id);

        $this->loanService->makeTransaction($request->validated());
        $this->userService->alterBalance($client, $request->amount, type: $request->type);

        return redirect()->route('transaction.edit')->with('flash', ['success' => 'Solde crédité avec succès.']);
    }

    public function transactionsHistory(Request $request)
    {
        $transactions = $this->userService->getTransactions($request->user());
        return Inertia::render('settings/History', [
            'transactions' => $transactions->map(fn($transaction) => [
                'id' => $transaction->id,
                'client_id' => $transaction->client_id,
                'amount' => $transaction->amount,
                'label' => $transaction->label,
                'type' => $transaction->type == 'deposit' ? 'Crédit' : 'Débit',
                'created_at' => Carbon::parse($transaction->created_at)->locale('fr')->isoFormat('D MMMM YYYY'),
            ]),
        ]);
    }
}
