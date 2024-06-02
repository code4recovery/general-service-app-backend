@extends('layouts.app')

@section('title', 'Register')

@section('description', 'District Committee Members log in here.')

@section('content')

    <div class="container max-w-3xl mx-auto px-4 grid gap-4">

        <h1 class="text-2xl font-bold">Register</h1>

        <p>Are you a District Chair? In some places this is called a DCMC (District Committee Member Chairperson) and in
            others it's a DCM (District Committee Member).</p>

        <form class="grid gap-12 mt-5">
            <fieldset class="grid gap-5 border-t pt-4 border-gray-500">
                <legend class="px-2 mx-auto">About You</legend>

                <div class="flex gap-5 w-full">
                    <div class="grid gap-1 w-full">
                        <label for="name" class="block">Your Name</label>
                        <input type="text" name="name" id="name" required
                            class="w-full p-2 border border-gray-300 rounded text-black">
                    </div>

                    <div class="grid gap-1 w-full">
                        <label for="email" class="block">Email Address</label>
                        <input type="email" name="email" id="email" placeholder="email@district.org" required
                            class="w-full p-2 border border-gray-300 rounded text-black">
                    </div>
                </div>
            </fieldset>

            <fieldset class="grid gap-5 border-t pt-4 border-gray-500">
                <legend class="px-2 mx-auto">About Your District</legend>
                <div class="flex gap-5 w-full">
                    <div class="grid gap-1 w-full">
                        <label for="area" class="block">Area</label>
                        <select name="area" id="area" required
                            class="w-full p-2 border border-gray-300 rounded appearance-none text-black">
                            <option selected>Area 1</option>
                        </select>
                    </div>
                    <div class="grid gap-1 w-full">
                        <label for="area" class="block">District</label>
                        <input type="number" name="district" id="district" required
                            class="w-full p-2 border border-gray-300 rounded text-black" min="1">
                    </div>
                </div>

                <div class="flex gap-5 w-full">
                    <div class="grid gap-1 w-full">
                        <label for="district-name" class="block">District Location</label>
                        <input type="text" name="district-name" id="district-name" placeholder="San Francisco" required
                            class="w-full p-2 border border-gray-300 rounded text-black">
                    </div>
                    <div class="grid gap-1 w-full">
                        <label for="name" class="block">District Website (optional)</label>
                        <input type="url" name="name" id="name" placeholder="https://district.org"
                            class="w-full p-2 border border-gray-300 rounded text-black">
                    </div>
                </div>
            </fieldset>

            <div class="w-full flex justify-center">
                <input type="submit" value="Register"
                    class="bg-blue-600 hover:bg-blue-700 py-2 px-6 rounded font-semibold text-white">
            </div>
        </form>


    </div>

@endsection
