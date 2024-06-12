<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\District;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'max:255'],
        ]);

        if (Auth::attempt($credentials, true)) {
            $user = Auth::user();

            $user->last_seen = now();
            $user->save();

            $district = Auth::user()->districts()->first();
            return redirect()->route('entity', [$district->area_id, $district->number]);
        }

        return back()->with('error', 'Invalid credentials');
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
            'users' => User::all()
        ]);
    }

    public function create()
    {
        return view('user', [
            'districts' => District::all()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->password = Hash::make(request('password'));
        $user->admin = request('admin') === 'on';
        $user->save();

        foreach ($request->input('districts') as $district) {
            $user->districts()->attach($district);
        }

        return redirect()->route('users.index')->with('success', 'User created');
    }

    public function edit(string $id)
    {
        return view('user', [
            'user' => User::find($id),
            'districts' => District::all()
        ]);
    }

    public function update(string $id)
    {
        $user = User::find($id);

        $user->name = request('name');
        $user->email = request('email');
        $user->admin = request('admin') === 'on';

        $user->save();

        //save districts
        $user->districts()->sync(request('districts'));

        return redirect()->route('users.index')->with('success', 'User updated');
    }

    public function destroy(string $id): RedirectResponse
    {
        $user = User::find($id);

        $user->districts()->detach();

        $user->delete();


        return redirect()->route('users.index')->with('success', 'User deleted');
    }

}
