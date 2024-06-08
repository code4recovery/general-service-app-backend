<div class="grid gap-1 w-full">
    <label for="{{ $name }}" class="block">{{ $label }} @if (empty($required))
            <span class="text-gray-400">• optional</span>
        @endif
    </label>
    @if ($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $name }}" rows="4"
        @if (!empty($required)) required="{{ $required }}" @endif @else <input
            type="{{ $type }}" value="{{ old($name, $value ?? null) }}" @endif
    name="{{ $name }}" id="{{ $name }}"
        @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
        @if (!empty($required)) required="{{ $required }}" @endif
        @isset($min) min="{{ $min }}" @endisset
        class="w-full p-2 border border-gray-300 rounded text-black"
        @if ($type === 'textarea') >{{ old($name, $value ?? null) }}</textarea>
    @else
        /> @endif
</div>
