<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\District;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {

        // todo check if the district already exists

        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'max:255', 'confirmed'],
            'area' => ['required', 'exists:areas,id'],
            'district' => ['required', 'numeric', 'min:1', 'max:99',
                Rule::unique('districts', 'number')->where('area_id', $request->input('area_id'))],
            'location' => ['required'],
            'website' => ['max:255'],
            'timezone' => ['max:255'],
        ]);

        // todo save the registration

        // temp save user & district
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $district = District::create([
            'area_id' => $validated['area'],
            'number' => $validated['district'],
            'name' => $validated['location'],
            'website' => $validated['website'],
        ]);

        $user->districts()->attach($district);

        // todo send verification email

        return redirect()->route('register')->with('success', 'Thank you! Please check your email for a verification message.');
    }
}
