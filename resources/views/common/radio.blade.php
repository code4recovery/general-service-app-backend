<div class="grid gap-1 w-full">
    <label for="type" class="block">{{ $label }}</label>
    <div class="flex rounded border divide-x border-neutral-300 divide-neutral-300">
        @foreach ($options as $key => $label)
            <label @class([
                'flex items-center justify-center w-full hover:bg-neutral-300 hover:text-neutral-900 cursor-pointer h-11 relative',
                'rounded-l' => $loop->first,
                'rounded-r' => $loop->last,
            ])
                :class="{ 'bg-white hover:bg-white text-neutral-800 font-bold': {{ $name }} === '{{ $key }}' }">
                <input @class([
                    'appearance-none absolute top-0 left-0 right-0 bottom-0 cursor-pointer',
                    $focusClasses,
                    'rounded-l' => $loop->first,
                    'rounded-r' => $loop->last,
                ]) type="radio" name="{{ $name }}" value="{{ $key }}"
                    required x-model="{{ $name }}" :checked="{{ $name }} === '{{ $key }}'" />
                {{ $label }}
            </label>
        @endforeach
    </div>
</div>
