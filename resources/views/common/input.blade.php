<div class="grid gap-1 w-full">
    <label for="{{ $name }}" class="block">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
        @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
        @if (!empty($required)) required="{{ $required }}" @endif
        @isset($min) min="{{ $min }}" @endisset
        class="w-full p-2 border border-gray-300 rounded text-black" value="{{ old($name) }}">
</div>
