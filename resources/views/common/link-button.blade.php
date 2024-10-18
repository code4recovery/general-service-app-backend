<a href="{{ $href }}" @class([
    'rounded overflow-hidden px-6 py-3 flex gap-3 items-center',
    $border_css,
    $hover_css,
])>
    @isset($icon)
        @include('common.icon', ['icon' => $icon])
    @endisset
    {{ $label }}
</a>
