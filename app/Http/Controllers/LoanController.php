<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Services\LoanService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\NewLoanRequest;
use App\Mail\LoanRequestNotification;
use Illuminate\Http\Request;

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

        // Générer un code pour le client
        $this->loanService->generateLoanCode($loan);

        $loan->refresh();

        // Envoyer un mail au gestionnaire
        Mail::to(config('mail.from.address'))->send(new LoanRequestNotification($loan));

        return redirect()->route('loan.edit')->with('status', ['success' => 'Demande de prêt envoyée avec succès.']);
    }

    public function verifyCode(NewLoanRequest $request, string $id)
    {
        $loan = $this->loanService->findById($id);

        if ($this->loanService->verifyCode($loan, $request->code)) {
            $this->loanService->generateLoanCode($loan);

            return redirect()->route('loan.edit')->with('status', ['success' => 'Demande de prêt approuvée.']);
        }

        return redirect()->route('loan.edit')->with('status', ['error' => 'Code incorrect.']);
    }

    public function approveLoan(Request $request, string $id) {
        $loan = $this->loanService->findById($id);

        $loan->update([
            'status' => 'approved',
            'code' => null
        ]);

        return redirect()->route('loan.edit')->with('status', ['success' => 'Demande de prêt approuvée.']);
    }
}
