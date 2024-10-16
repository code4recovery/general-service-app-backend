<span class="border rounded-full flex px-3 py-1 items-center gap-2 border-gray-500">
    {{ $user->email }}
    <a href="{{ route('remove-user', [$user->id, isset($entity) ? $entity->id : null]) }}">
        @include('common.icon', ['icon' => 'x', 'size' => 'size-5'])
    </a>
</span>
