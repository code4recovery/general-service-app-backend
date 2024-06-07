@if ($errors->any())
    <div class="bg-red-200 dark:bg-red-700 border-l-6 border-red-900 px-4 py-2 rounded">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
