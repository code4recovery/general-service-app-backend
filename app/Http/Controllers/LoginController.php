<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LoginToken;

class LoginController extends Controller
{
    public function login_form()
    {
        // redirect if already logged in
        if (auth()->check()) {
            $entity = Auth::user()->entities()->first();
            return redirect()->route('entities.stories.index', $entity);
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $user = User::whereEmail($credentials['email'])->first();

        if ($user) {
            $user->sendLoginLink();
            return redirect()->back()->with('success', __('Login link sent'));
        }

        return back()->with('error', __('Could not find that email address in our records.'));
    }


    public function verifyLogin(Request $request, $token)
    {
        $token = LoginToken::whereToken(hash('sha256', $token))->firstOrFail();
        if (!$request->hasValidSignature()) {
            return redirect()->route('login')->with('error', __('Login token is invalid, please try again.'));
        }
        if (!$token->isValid()) {
            return redirect()->route('login')->with('error', __('Login token has expired, please try again.'));
        }
        $token->consume();
        Auth::login($token->user, true);

        // todo this does not seem to work
        Auth::user()->update(['last_seen' => now()]);

        $entity = Auth::user()->entities()->first();
        return redirect()->route('entities.stories.index', $entity);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

}
