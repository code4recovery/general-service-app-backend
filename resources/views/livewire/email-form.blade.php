<form class="flex items-center gap-3" method="post" action="{{ route('add-user', compact('entity')) }}">
    @csrf
    @if (!$show)
        <button wire:click="$set('show', true)" @class(['rounded px-3 py-1 text-sm', $bg_css, $border_css]) type="button">
            {{ __('Add') }}
        </button>
    @else
        <div class="relative">
            <input type="email" name="email" autofocus autocomplete="off" data-1p-ignore @class(['bg-transparent rounded px-4 py-1 text-sm', $border_css])>
            <button wire:click="$set('show', false)" class="absolute right-3 inset-y-1/2 -mt-2" type="button">
                @include('common.icon', ['icon' => 'x', 'size' => 'size-4'])
            </button>
        </div>
    @endif
</form>
