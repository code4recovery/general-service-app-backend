@extends('layouts.app')

@section('title', 'General Service App')

@section('description', 'An app designed for A.A. General Service')

@section('content')

    <div class="max-w-3xl mx-auto px-4 grid gap-4">

        <h3 class="font-bold text-xl mt-3">Login</h3>
        <ol class="list-decimal pl-6 gap-2 grid">
            <li>Click Login button.</li>
            <li>Enter email associated with your General Service position. Click Submit.</li>
            <li>Check your email account. Click login link.</li>
        </ol>

        <h3 class="font-bold text-xl mt-3">Create Story</h3>
        <ol class="list-decimal pl-6 gap-2 grid">
            <li>Click Create Story.</li>
            <li>Enter Title e.g. “Bill & Bob Unity Day”</li>
            <li>Enter Description e.g. “Come join General Service, Intergroup, H&I, and YPAA’s Annual Service Fair on
                Saturday, June 10, 2025 at the Cathedral of Doctor Bob of the Assumption at 1935 Stepping Stones Street.”
            </li>
            <li>Choose Content Type. Available options include News (Announcement or Event), Business (current motions or
                discussion topics being discussed at the District/Area), or Resources (District/Area website, specific
                important webpages).</li>
            <li>Enter Story Date. End Dates that expire will cause the Story to fall off automatically.</li>
            <li>Click Submit.</li>
            <li>Pull down on to refresh the app on smart phone. Story will appear.</li>
            <li>Click on story and drag it before or after existing stories to re-order as needed.</li>
            <li>Pull down on to refresh the app on smart phone. Story will appear re-ordered.</li>
        </ol>

        <h3 class="font-bold text-xl mt-3">Edit Story</h3>
        <ol class="list-decimal pl-6 gap-2 grid">
            <li>Click on existing story.</li>
            <li>Edit story.</li>
            <li>Click Submit.</li>
            <li>Click on story and drag it before or after existing stories to re-order as needed.</li>
            <li>Pull down on to refresh the app on smart phone. Edited or re-ordered story will appear.</li>
        </ol>

        <h3 class="font-bold text-xl mt-3">Story Page Content</h3>
        <ol class="list-decimal pl-6 gap-2 grid">
            <li>News is for general announcements and events that are emergent and most dynamic in time. Examples include
                “Unity Day”, Plain Language Big Book availability, International Convention Registration.</li>
            <li>Business is for motions, discussion topics, and items of deliberation in your service entity. Examples
                include New/Old Business, Housekeeping Motions and items happening at the District or Area. Stories here are
                generally longer in timeline scope.</li>
            <li>Resources is for District/Area websites and any specific pages you would like to highlight. Stories here are
                long-term in scope.</li>
        </ol>

    </div>

@endsection
