@isset($href)
<a href="{{ $href }}" @isset($target)) target="{{ $target }}" 
@endisset @else <button
    type="button" @isset($click)) @click="{{ $click }}" @endisset @endisset
    @isset($aria_label) aria-label="{{ $aria_label }}" @endisset
    class="bg-black/10 dark:bg-white/10 hover:bg-black/15 hover:dark:bg-white/15 hover:dark:text-white px-6 py-2 rounded font-semibold text-gray-900 text-center text-nowrap"
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
