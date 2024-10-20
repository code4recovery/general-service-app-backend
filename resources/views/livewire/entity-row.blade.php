<div class="flex flex-wrap gap-3 items-center py-3">
    <a href="{{ route('entities.stories.index', $entity->id) }}" class="hover:underline lg:min-w-72">
        {{ $entity->name() }}
    </a>
    @if ($active)
        @foreach ($entity->users as $user)
            <span @class([
                'rounded flex px-3 py-1 items-center gap-2 text-sm',
                $border_css,
                $bg_css,
            ])>
                {{ $user->email }}
                <a wire:click="remove({{ $user->id }})">
                    @include('common.icon', ['icon' => 'x', 'size' => 'size-4'])
                </a>
            </span>
        @endforeach
        @if (count($entity->users) < 3)
            <form class="flex items-center gap-3" method="post" wire:submit="add">
                @csrf
                @if (!$show)
                    <button wire:click="$set('show', true)" @class(['rounded px-3 py-1 text-sm', $bg_css, $border_css]) type="button">
                        {{ __('Add') }}
                    </button>
                @else
                    <div class="relative">
                        <input type="email" wire:model="email" autofocus autocomplete="off" data-1p-ignore
                            @class(['bg-transparent rounded px-4 py-1 text-sm', $border_css])>
                        <button wire:click="$set('show', false)" class="absolute right-3 inset-y-1/2 -mt-2"
                            type="button">
                            @include('common.icon', ['icon' => 'x', 'size' => 'size-4'])
                        </button>
                    </div>
                @endif
            </form>
        @endif
    @endif
</div>
