<div class="grid gap-1 w-full">
    <label for="{{ $name }}" class="block">{{ $label }}</label>
    <div>
        <select name="{{ $name }}" id="{{ $name }}" @class([
            'w-full p-2 border border-gray-300 rounded text-black appearance-none h-11',
            $focusClasses,
        ]) required>
            @foreach ([
        'America/Halifax' => __('Atlantic Time'),
        'America/New_York' => __('Eastern Time'),
        'America/Chicago' => __('Central Time'),
        'America/Denver' => __('Mountain Time'),
        'America/Phoenix' => __('Arizona Time'),
        'America/Los_Angeles' => __('Pacific Time'),
        'America/Anchorage' => __('Alaska Time'),
        'Pacific/Honolulu' => __('Hawaii Time'),
    ] as $timezone => $description)
                <option value="{{ $timezone }}" @if ($value === $timezone) selected @endif>
                    {{ $description }}
                </option>
            @endforeach
        </select>
    </div>
</div>
