<span @class([
    'rounded flex px-3 py-1 items-center gap-2 text-sm',
    $border_css,
    $bg_css,
])>
    {{ $user->email }}
    <a href="{{ route('remove-user', [$user->id, isset($entity) ? $entity->id : null]) }}">
        @include('common.icon', ['icon' => 'x', 'size' => 'size-4'])
    </a>
</span>
