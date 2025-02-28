<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\VerifyRequest;
use App\Models\User;
use App\Services\VerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(private readonly VerificationService $verificationService)
    {
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $validated = $request->validated();
        $verification = $this->verificationService->sendVerification($currentUser->id, json_encode($validated));
        return Redirect::route('profile.verify.form', ['uuid' => $verification->uuid]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('home');
    }

    public function verify(VerifyRequest $request): RedirectResponse
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $verification = $request->verification;

        $userData = json_decode($verification->data, true, 512, JSON_THROW_ON_ERROR);
        DB::transaction(static function () use ($verification, $currentUser, $userData) {
            $currentUser->fill($userData);

            if ($currentUser->isDirty('email')) {
                $currentUser->email_verified_at = null;
            }

            $currentUser->save();
            $verification->delete();
        });
        return Redirect::route('dashboard');
    }

    public function verifyForm(Request $request): View
    {
        $uuid = $request->route('uuid');
        return view('profile.verify', ['uuid' => $uuid]);
    }
}
