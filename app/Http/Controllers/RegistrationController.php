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

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // validate language (can this move to the model?)
        $default_language = 'en';
        $language = $request->input('language', $default_language);
        if (!in_array($language, ['en', 'es', 'fr'])) {
            $language = $default_language;
        }

        // validate timezone (can this move to the model?)
        $default_timezone = 'America/New_York';
        $timezone = $request->input('timezone', $default_timezone);
        if (!in_array($timezone, timezone_identifiers_list())) {
            $timezone = $default_timezone;
        }

        $district = District::create([
            'area_id' => $validated['area'],
            'number' => $validated['district'],
            'name' => $validated['location'],
            'website' => $validated['website'],
            'language' => $language,
            'timezone' => $timezone,
        ]);

        $user->districts()->attach($district);

        return redirect()->route('register')->with('success', 'Thank you! Please check your email for a verification message.');
    }
}
