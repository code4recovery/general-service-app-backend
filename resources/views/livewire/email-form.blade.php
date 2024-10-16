<form class="flex items-center gap-3" method="post" action="{{ route('add-user', compact('entity')) }}">
    @csrf
    @if (!$show)
        <button wire:click="$set('show', true)" class="bg-transparent border rounded-full px-3 py-1" type="button">
            @include('common.icon', ['icon' => 'plus'])
        </button>
    @else
        <div class="relative">
            <input type="email" name="email" autofocus autocomplete="off" data-1p-ignore
                class="bg-transparent border rounded-full px-4 py-1">
            <button wire:click="$set('show', false)" class="absolute right-3 inset-y-1/2 -mt-2.5" type="button">
                @include('common.icon', ['icon' => 'x', 'size' => 'size-5'])
            </button>
        </div>
    @endif
</form>
