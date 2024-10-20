@component('mail::message')
    <p>
        {!! __(
            'Welcome to the General Service App! For info on how to use this site please check out the <a :link>get started</a> page.',
            ['link' => 'href="https://generalservice.app/get-started"'],
        ) !!}
    </p>
    @component('mail::button', ['url' => $url])
        {{ __('Click to login') }}
    @endcomponent
    @component('mail::footer')
        {{ __('This email was sent :now (GMT)', ['now' => now()->toDayDateTimeString()]) }}
    @endcomponent
@endcomponent
