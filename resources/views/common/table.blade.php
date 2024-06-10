@if (!count($rows))
    <p class="h-48 bg-gray-300 dark:bg-gray-600 flex justify-center items-center rounded-md">
        {{ $empty }}
    </p>
@else
    <div class="overflow-x-auto">
        <table class="table-fixed min-w-full">
            <thead>
                <tr>
                    @foreach (array_keys($rows[0]) as $label)
                        @if ($label === 'href')
                            @continue
                        @endif
                        <th @class([
                            'border-b border-gray-300 dark:border-gray-600 font-light p-3',
                            'text-left' => $loop->index < 2,
                            'text-right' => $loop->index > 1,
                            'w-1/2' => $loop->first,
                            'w-1/6' => !$loop->first,
                        ])>
                            {{ $label }}
                        </th>
                    @endforeach
                </tr>
                @foreach ($rows as $row)
                    <tr class="hover:bg-gray-300 dark:hover:bg-gray-600">
                        @foreach ($row as $label => $value)
                            @if ($label === 'href')
                                @continue
                            @endif
                            <td @class([
                                'border border-gray-300 dark:border-gray-600',
                                'text-left' => $loop->index < 2,
                                'text-right' => $loop->index > 1,
                            ])>
                                <a href="{{ $row['href'] }}" class="p-3 block">
                                    {{ $value }}
                                </a>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
        </table>
    </div>
@endif
