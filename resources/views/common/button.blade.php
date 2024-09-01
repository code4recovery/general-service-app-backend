@isset($href)
<a href="{{ $href }}" @isset($target)) target="{{ $target }}"
@endisset @else <button
    type="button" @isset($click)) @click="{{ $click }}" @endisset @endisset
    class="bg-gray-300 dark:bg-gray-400 hover:bg-white/50 hover:dark:bg-white/15 hover:dark:text-white py-2 px-6 rounded font-semibold text-gray-900 text-center text-nowrap"
    @isset($highlighted) :class="{ 'bg-white/50 dark:bg-white/15 dark:text-white': {{ $highlighted }} }" @endisset>
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
