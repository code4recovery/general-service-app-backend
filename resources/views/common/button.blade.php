@isset($href)
<a href="{{ $href }}" @isset($target)) target="{{ $target }}"
@endisset @else <button
    type="button" @isset($click)) @click="{{ $click }}" @endisset @endisset
    class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-400 dark:hover:bg-white py-2 px-6 rounded font-semibold text-gray-900 text-center">

    @isset($label)
        {{ $label }}
    @endisset

    @isset($icon)
        @include('common.icon', ['icon' => $icon])
    @endisset

    @isset($href)
    </a>
@else
    </button>
@endisset
