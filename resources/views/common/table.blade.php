@if (!count($rows))
    <p @class(['h-48 flex justify-center items-center rounded-md', $bg_css])>
        {{ $empty }}
    </p>
@else
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full align-middle sm:px-6 lg:px-8">
            <table class="table-fixed min-w-full border-collapse">
                <thead x-data="{ columns: @js($columns) }">
                    <tr>
                        @if (isset($reorder) && count($rows) > 1)
                            <th @class(['font-light p-3 border-x-0 border-t-0 w-3', $border_css])></th>
                        @endif
                        <template x-for="(column, index) in columns" :key="index">
                            <th @class(['font-light p-3 border-x-0 border-t-0', $border_css])
                                :class="{
                                    'text-left': index < 2,
                                    'text-right': index > 1,
                                    'w-1/2': !index,
                                    'w-1/6': index && columns.length === 4,
                                    'w-1/4': index && columns.length === 3,
                                }"
                                x-text="column"></th>
                        </template>
                    </tr>
                </thead>

                <tbody x-data="{ rows: @js($rows) }" x-sort:config="{ handle: '[x-sort\\:handle]' }"
                    @if (isset($reorder) && count($rows) > 1) x-sort="(item, position) => {
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
                    }" @endif>
                    <template x-for="(row, index) in rows" :key="index">
                        <tr @class(['select-none table-row', $hover_css])
                            @if (isset($reorder) && count($rows) > 1) x-sort:item="row.id"
                            x-bind:data-id="row.id" @endif>
                            @if (isset($reorder) && count($rows) > 1)
                                <td x-sort:handle @class(['p-3 cursor-grab w-5', $border_css])>
                                    @include('common.icon', ['icon' => 'bars-3'])
                                </td>
                            @endif
                            <template x-for="(value, index) in row.values" :key="index">
                                <td @class(['table-cell', $border_css])
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
