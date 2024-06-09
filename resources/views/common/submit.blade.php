<div class="flex flex-wrap gap-3">
    <input class="bg-blue-600 hover:bg-blue-700 py-2 px-6 rounded font-semibold text-white cursor-pointer" type="submit"
        value="Submit">
    @isset($cancel)
        @include('common.button', [
            'href' => $cancel,
            'label' => 'Cancel',
        ])
    @endisset
    @isset($delete)
        <a class="bg-red-600 hover:bg-red-700 py-2 px-6 rounded font-semibold text-white ml-auto" href="{{ $delete }}">
            Delete
        </a>
    @endisset
</div>
