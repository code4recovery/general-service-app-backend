@if (!count($rows))
    <p class="h-48 bg-gray-300 dark:bg-gray-600 flex justify-center items-center rounded-md">
        {{ $empty }}
    </p>
@else
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="table-fixed min-w-full border-collapse">
                <thead x-data="{ headings: @js($headings) }">
                    <tr>
                        @isset($reorder)
                            <th class="border-b border-gray-300 dark:border-gray-600 font-light p-3"></th>
                        @endisset
                        <template x-for="(heading, index) in headings" :key="index">
                            <th class="border-b border-gray-300 dark:border-gray-600 font-light p-3"
                                :class="{
                                    'text-left': index < 2,
                                    'text-right': index > 1,
                                    'w-1/2': !index,
                                    'w-1/6': index,
                                }"
                                x-text="heading"></th>
                        </template>
                    </tr>
                </thead>

                <tbody x-data="{ rows: @js($rows) }"
                    @isset($reorder) x-sort="(item, position) => {
                        const order = [...document.querySelectorAll('tr[data-id]')].map((e) => parseInt(e.getAttribute('data-id')));
                        order.splice(position, 0, order.splice(order.indexOf(item), 1)[0]);
                        fetch('{{ $reorder }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Csrf-Token': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ order })
                        });
                    }" @endisset>
                    <template x-for="(row, index) in rows" :key="index">
                        <tr class="hover:bg-gray-300 dark:hover:bg-gray-600 select-none table-row"
                            @isset($reorder) x-sort:item="row.id" x-bind:data-id="row.id">
                                <td x-sort:handle class="border border-gray-300 dark:border-gray-600 p-3 cursor-grab">
                                    @include('common.icon', ['icon' => 'bars-3'])
                                </td>
                            @endisset>
                            <template x-for="(value, index) in row.values" :key="index">
                                <td class="border border-gray-300 dark:border-gray-600 table-cell"
                                    :class="{
                                        'text-left': index < 2,
                                        'text-right': index > 1,
                                    }">
                                    <a x-bind:href="row.href" class="p-3 block" x-text="value"></a>
                                </td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
@endif
