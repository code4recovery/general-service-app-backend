<div class="grid gap-1 w-full">
    <label for="{{ $name }}" class="block">{{ $label }}</label>
    <div>
        <select name="{{ $name }}" id="{{ $name }}" @class([
            'w-full p-2 border border-gray-300 rounded text-black appearance-none h-11',
            $focusClasses,
        ]) required>
            @foreach ([
        'America/Halifax' => 'Atlantic Time',
        'America/New_York' => 'Eastern Time',
        'America/Chicago' => 'Central Time',
        'America/Denver' => 'Mountain Time',
        'America/Phoenix' => 'Arizona Time',
        'America/Los_Angeles' => 'Pacfic Time',
        'America/Anchorage' => 'Alaska Time',
        'Pacific/Honolulu' => 'Hawaii Time',
    ] as $timezone => $description)
                <option value="{{ $timezone }}" @if ($value === $timezone) selected @endif>
                    {{ $description }}
                </option>
            @endforeach
        </select>
    </div>
</div>
