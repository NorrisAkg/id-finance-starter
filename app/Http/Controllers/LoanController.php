<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncreaseBalanceRequest;
use App\Models\Loan;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\LoanService;
use App\Mail\LoanCodeVerification;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\NewLoanRequest;
use App\Mail\LoanRequestNotification;
use App\Http\Requests\LoanCodeVerificationRequest;
use App\Services\UserService;

class LoanController extends Controller
{
    public function __construct(protected LoanService $loanService, protected UserService $userService)
    {
        $this->middleware('auth')->except('show');
    }

    public function edit()
    {
        $loanId = request()->has('loan_id')
            ? request('loan_id')
            : null;

        /** @var Loan $loan */
        $loan = request()->has('loan_id')
            ? Loan::find(request('loan_id'))
            : $this->loanService->getUserLatestPendingLoan(request()->user());

        // dd($loan);

        return request()->user()->is_admin ? redirect()->route('transaction.edit') : Inertia::render('settings/Loan', [
            'loan' => $loan,
            'loanId' => $loanId,
        ]);
    }

    public function store(NewLoanRequest $request)
    {
        /** @var User $user */
        $user = $request->user();

        $loan = $this->loanService->makeRequest(data: $request->except(['user_id']), user: $user);

        // Générer un code pour le client
        $this->loanService->generateLoanCode($loan);

        $loan->refresh();

        $request->user()->load('loans');

        // Envoyer un mail au gestionnaire
        Mail::to(config('mail.from.address'))->send(new LoanRequestNotification($loan));

        // dd($loan->toArray());

        return redirect()->route('loan.edit', ['loan_id' => $loan->id])->with(['status', ['success' => 'Demande de prêt envoyée avec succès.']]);
    }

    public function show(Loan $loan)
    {
        return response()->json($loan);
    }

    public function getLatestPendingLoan()
    {
        $loan = $this->loanService->getUserLatestPendingLoan(request()->user());

        return response()->json($loan);
    }

    public function verifyCode(LoanCodeVerificationRequest $request, Loan $loan)
    {
        if ($this->loanService->verifyCode($loan, $request->code)) {
            $loan->update([
                'code_verified_count' => $loan->code_verified_count + 1
            ]);
            $this->loanService->generateLoanCode($loan);
            $loan->refresh();

            if($loan->code_verified_count == 4) {
                $this->approveLoan(loan: $loan);
                return;
            } else {
                // Envoyer un mail au gestionnaire
                Mail::to(config('mail.from.address'))->send(new LoanCodeVerification($loan));
            }

            return redirect()->route('loan.edit', ['loan_id' => $loan->id])->with('status', ['success' => 'Demande de prêt approuvée.']);
        }

        return redirect()->route('loan.edit', ['loan_id' => $loan->id])->with('status', ['error' => 'Code incorrect.']);
    }

    public function approveLoan(Loan $loan)
    {
        $loan->update([
            'status' => 'approved',
            'code' => null
        ]);

        return redirect()->route('loan.edit', ['loan_id' => $loan->id])->with('status', ['success' => 'Demande de prêt approuvée.']);
    }
}
