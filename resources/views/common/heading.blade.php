<div class="flex items-center justify-between min-h-10 w-full">
    <h1 class="text-2xl font-bold flex flex-wrap gap-3 items-center">
        @isset($breadcrumbs)
            @foreach ($breadcrumbs as $url => $breadcrumb)
                <a href="{{ $url }}" class="underline">
                    {{ Str::limit($breadcrumb, 30, '…') }}
                </a>
                @include('common.icon', ['icon' => 'chevron-right', 'size' => 'size-3'])
            @endforeach
        @endisset
        {{ $title }}
    </h1>
    @isset($button)
        @include('common.button', $button)
    @endisset
</div>
