<?php

namespace App\Http\Controllers\Settings;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Services\CountryService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Requests\Settings\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function __construct(protected CountryService $countryService) {}

    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response | RedirectResponse
    {
        $target = $request->user()->is_admin
        ? redirect()->route('transaction.edit')
        : Inertia::render('settings/Profile', [
            // 'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
            // 'country' => $this->countryService->getById($request->user()->country_id),
        ]);

        return $target;
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return to_route('profile.edit');
    }

    public function getBalance(Request $request): Response|RedirectResponse {
        return request()->user()->is_admin ? redirect()->route('transaction.edit') : Inertia::render('settings/Balance', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Delete the user's profile.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
