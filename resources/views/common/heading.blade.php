<div class="flex items-center justify-between w-full">
    <h1 class="text-2xl font-bold">
        {{ $title }}
    </h1>
    @isset($button)
        @include('common.button', $button)
    @endisset
</div>
