<div class="grid gap-1 w-full">
    <label for="type" class="block">{{ $label }}</label>
    <div class="flex rounded border divide-x border-neutral-300 divide-neutral-300">
        @foreach ($options as $key => $label)
            <label @class([
                'flex items-center justify-center w-full cursor-pointer h-11 relative',
                'rounded-l' => $loop->first,
                'rounded-r' => $loop->last,
            ])
                :class="{ '{{ $bg_css }}': {{ $name }} === '{{ $key }}' }">
                <input @class([
                    'appearance-none absolute top-0 left-0 right-0 bottom-0 cursor-pointer',
                    'rounded-l' => $loop->first,
                    'rounded-r' => $loop->last,
                ]) type="radio" name="{{ $name }}" value="{{ $key }}"
                    required x-model="{{ $name }}" :checked="{{ $name }} === '{{ $key }}'" />
                {{ __($label) }}
            </label>
        @endforeach
    </div>
</div>
