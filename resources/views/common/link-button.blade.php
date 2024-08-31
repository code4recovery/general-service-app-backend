<a href="{{ $href }}"
    class="border border-gray-300 dark:border-gray-500 rounded overflow-hidden px-6 py-3 flex gap-3 items-center hover:bg-white/50 hover:dark:bg-white/15">
    @isset($icon)
        @include('common.icon', ['icon' => $icon])
    @endisset
    {{ $label }}
</a>
