<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Entity;
use App\Models\User;
use App\Models\LoginToken;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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
        abort_unless($request->hasValidSignature() && $token->isValid(), 401);
        $token->consume();
        Auth::login($token->user, true);

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

    public function index()
    {
        return view('users', [
            'users' => User::with('entities')->get()
        ]);
    }

    public function create()
    {
        return view('user', [
            'entities' => Entity::orderBy('area')->orderBy('district')->get()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->admin = request('admin') === 'on';
        $user->save();

        foreach ($request->input('entities') as $district) {
            $user->entities()->attach($district);
        }

        return redirect()->route('users.index')->with('success', __('User created.'));
    }

    public function edit(string $id)
    {
        return view('user', [
            'user' => User::find($id),
            'entities' => Entity::orderBy('area')->orderBy('district')->get()
        ]);
    }

    public function update(string $id)
    {
        $user = User::find($id);

        $user->name = request('name');
        $user->email = request('email');
        $user->admin = request('admin') === 'on';

        $user->save();

        // save entities
        $user->entities()->sync(request('entities'));

        return redirect()->route('users.index')->with('success', __('User updated.'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $user = User::find($id);

        $user->entities()->detach();

        $user->delete();

        return redirect()->route('users.index')->with('success', __('User deleted.'));
    }

}
