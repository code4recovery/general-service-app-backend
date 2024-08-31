<div class="grid gap-1 w-full">
    <label for="type" class="block">{{ $label }}</label>
    <div class="flex rounded border divide-x border-neutral-300 divide-neutral-300 overflow-hidden">
        @foreach ($options as $key => $label)
            <label class="flex items-center justify-center cursor-pointer w-full hover:bg-neutral-300 h-11"
                :class="{ 'bg-white hover:bg-white text-neutral-800 font-bold': {{ $name }} === '{{ $key }}' }">
                <input class="hidden" type="radio" name="{{ $name }}" value="{{ $key }}" required
                    x-model="{{ $name }}" :checked="{{ $name }} === '{{ $key }}" />
                {{ $label }}
            </label>
        @endforeach
    </div>
</div>
