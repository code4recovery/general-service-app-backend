@component('mail::message')
    @component('mail::button', ['url' => $url])
        {{ __('Click to login') }}
    @endcomponent
@endcomponent
