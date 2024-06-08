<div class="flex flex-wrap gap-3">
    <input class="bg-blue-600 hover:bg-blue-700 py-2 px-6 rounded font-semibold text-white" type="submit" value="Submit">
    @isset($buttons)
        @foreach ($buttons as $href => $label)
            @include('common.button', [
                'href' => $href,
                'label' => $label,
            ])
        @endforeach
    @endisset
</div>
