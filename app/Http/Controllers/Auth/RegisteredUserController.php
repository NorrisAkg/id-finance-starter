<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Tools\FileUploadTrait;
use App\Services\CountryService;
use App\Mail\NewUserNotification;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\RegistrationRequest;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    use FileUploadTrait;

    public function __construct(protected CountryService $countryService) {}

    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register', [
            'countries' => $this->countryService->getAll(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegistrationRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            $data['password'] = Hash::make($data['password']);

            if (isset($data['picture']) && $data['picture'] instanceof UploadedFile) {
                $data['picture'] = $this->upload($data['picture'], 'users');
            }

            $user = User::create($data);

            // Génération du code client
            $user->client_code = rand(10000, 99999);
            $user->save();

            // Envoi d'un email à l'admin
            Mail::to('admin@example.com')->send(new NewUserNotification($user));

            return redirect()->route('login')->with('flash', [
                'success' => 'Inscription réussie! Veuillez contacter votre gestionnaire pour obtenir votre code client et vous connecter.'
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('flash', [
                'error' => 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.'
            ]);
        }
    }
}
