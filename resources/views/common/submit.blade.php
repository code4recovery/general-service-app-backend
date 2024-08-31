<div class="flex flex-wrap gap-3 mt-4">
    <input class="bg-blue-600 hover:bg-blue-700 py-2 px-6 rounded font-semibold text-white cursor-pointer" type="submit"
        value="{{ __('Submit') }}">
    @isset($cancel)
        @include('common.button', [
            'href' => $cancel,
            'label' => __('Cancel'),
        ])
    @endisset
    @isset($delete)
        <a class="bg-red-600 hover:bg-red-700 py-2 px-6 rounded font-semibold text-white ml-auto" href="{{ $delete }}">
            {{ __('Delete') }}
        </a>
    @endisset
</div>
