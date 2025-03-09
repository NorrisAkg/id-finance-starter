<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Services\LoanService;
use Illuminate\Routing\Controller;
use App\Http\Requests\NewLoanRequest;

class LoanController extends Controller
{
    public function __construct(protected LoanService $loanService)
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        return Inertia::render('settings/Loan', []);
    }

    public function store(NewLoanRequest $request)
    {
        /** @var User $user */
        $user = $request->user();
        $loan = $this->loanService->makeRequest(data:$request->except(['user_id']), user: $user);

        return redirect()->route('loan.edit', $loan->id)->with('status', 'Demande de prêt envoyée avec succès.');
    }
}
