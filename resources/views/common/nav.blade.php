<div class="flex flex-col sm:flex-row gap-3 space-between">
    <nav
        class="border border-gray-300 dark:border-gray-500 divide-y sm:divide-x sm:divide-y-0 divide-gray-300 dark:divide-gray-500 sm:mr-auto rounded flex flex-col sm:flex-row overflow-hidden">
        @foreach ($links as $navhref => [$icon, $label])
            <a href="{{ $navhref }}" @class([
                'px-6 py-3 flex gap-3 items-center hover:bg-white/50 hover:dark:bg-white/15',
                'bg-white/50 dark:bg-white/15' => Request::url() === $navhref,
            ])>
                @include('common.icon', ['icon' => $icon])
                {{ $label }}
            </a>
        @endforeach
    </nav>
    @isset($button)
        <a href="{{ $button['href'] }}"
            class="border border-gray-300 dark:border-gray-500 rounded overflow-hidden px-6 py-3 flex gap-3 items-center hover:bg-white/50 hover:dark:bg-white/15">
            @isset($button['icon'])
                @include('common.icon', ['icon' => $button['icon']])
            @endisset
            {{ $button['label'] }}
        </a>
    @endisset
</div>
