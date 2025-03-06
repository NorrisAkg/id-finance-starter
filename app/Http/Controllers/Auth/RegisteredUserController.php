<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\CountryService;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Tools\FileUploadTrait;

class RegisteredUserController extends Controller
{
    use FileUploadTrait;

    public function __construct(protected CountryService $countryService)
    {

    }

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
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);

        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        if(isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            $data['photo'] = $this->upload($data['photo'], 'users');
        }

        $user = User::create($data);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('login')->with('flash', [
            'success' => 'Inscription réussie! Veuillez contacter votre gestionnaire pour obtenir votre code client et vous connecter.'
        ]);
    }
}
