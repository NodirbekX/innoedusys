<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = User::findOrFail($request->route('id'));

        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(403, 'This action is unauthorized.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('home.index', absolute: false).'?verified=1');
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return redirect()->intended(route('home.index', absolute: false).'?verified=1');
    }
}
