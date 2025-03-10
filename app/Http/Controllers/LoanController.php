<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Services\LoanService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\NewLoanRequest;
use App\Mail\LoanRequestNotification;

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
        

        // Envoyer un mail au gestionnaire
        Mail::to(config('mail.from.address'))->send(new LoanRequestNotification($loan));

        return redirect()->route('loan.edit')->with('status', ['success' => 'Demande de prêt envoyée avec succès.']);
    }
}
