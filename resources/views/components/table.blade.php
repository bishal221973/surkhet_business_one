@props([
    'headers' => [],
    'id' => 'datatable-' . uniqid(),
])

<div style="background-color: transparent;"
    class="d-flex justify-content-between p-2 align-items-center flex-wrap gap-2 ">

    @include('components.tableUtilities.rows')
    <div class="d-flex gap-1">

        @include('components.tableUtilities.search')
        @include('components.tableUtilities.export')
        @include('components.tableUtilities.columns')
        {{ $addButtons }}
    </div>
</div>
<div class="shadow1 my-table ">

    <div class="overflow-x-auto">
        <table id="{{ $id }}" class="min-w-full w-full  display nowrap main-table"  {{ $attributes->merge([
        'style' => 'border-collapse: collapse;'
    ]) }}>
            <thead class="table-head">
                <tr>
                    @foreach ($headers as $header)
                        <th class="px-4 py-2 text-left text-sm font-semibold" style="color: #005A9C">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between items-center mt-2 p-2">
        <div>
            Showing <span id="{{ $id }}-start">1</span> to <span id="{{ $id }}-end">1</span> of
            <span id="{{ $id }}-total">0</span> entries
        </div>
        <div class="d-flex gap-1 flex-wrap" id="{{ $id }}-pagination">
        </div>
    </div>
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('js/dataTables/datatables.min.css') }}">
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="{{ asset('js/dataTables/datatables.min.js') }}"></script>

        <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        $(document).ready(function() {
            const table = $('#{{ $id }}').DataTable({
                responsive: false,
                pageLength: 10,
                lengthChange: false,
                dom: 'lrtip',
                buttons: [{
                        extend: 'copy',
                        className: 'd-none',
                        name: 'copy'
                    },
                    {
                        extend: 'csv',
                        className: 'd-none',
                        name: 'csv'
                    },
                    {
                        extend: 'excel',
                        className: 'd-none',
                        name: 'excel'
                    },
                    {
                        extend: 'pdf',
                        className: 'd-none',
                        name: 'pdf'
                    },
                    {
                        extend: 'print',
                        className: 'd-none',
                        name: 'print'
                    },
                ]
            });

            const $pagination = $('#{{ $id }}-pagination');
            const $start = $('#{{ $id }}-start');
            const $end = $('#{{ $id }}-end');
            const $total = $('#{{ $id }}-total');

            function updatePagination() {
                const info = table.page.info();
                $start.text(info.start + 1);
                $end.text(info.end);
                $total.text(info.recordsTotal);

                $pagination.empty();

                const prevDisabled = info.page === 0 ? 'disabled' : '';
                $pagination.append(
                    `<button class="btn btn-sm btn-outline-primary" ${prevDisabled} data-page="${info.page - 1}">Prev</button>`
                    );

                for (let i = 0; i < info.pages; i++) {
                    const active = i === info.page ? 'active-btn' : '';
                    $pagination.append(
                        `<button class="btn btn-sm btn-outline-primary ${active}" data-page="${i}">${i + 1}</button>`
                        );
                }

                const nextDisabled = info.page === info.pages - 1 ? 'disabled' : '';
                $pagination.append(
                    `<button class="btn btn-sm btn-outline-primary" ${nextDisabled} data-page="${info.page + 1}">Next</button>`
                    );
            }

            updatePagination();

            table.on('draw', function() {
                updatePagination();
            });

            $pagination.on('click', 'button', function() {
                const page = $(this).data('page');
                table.page(page).draw('page');
            });

            $('#{{ $id }}-search').on('keyup', function() {
                table.search(this.value).draw();
            });

            $('#{{ $id }}-length').on('change', function() {
                table.page.len(this.value).draw();
            });

            $('#{{ $id }}-export-btn').on('click', function() {
                $('#{{ $id }}-export-menu').toggle();
                $('#{{ $id }}-colvis-menu').hide();
            });

            $('#{{ $id }}-export-menu li').on('click', function() {
                const action = $(this).data('action');
                table.button(action + ':name').trigger();
                $('#{{ $id }}-export-menu').hide();
            });

            $('#{{ $id }}-colvis-btn').on('click', function() {
                $('#{{ $id }}-colvis-menu').toggle();
                $('#{{ $id }}-export-menu').hide();
            });

            $('#{{ $id }}-colvis-menu li').on('click', function() {
                const columnIndex = $(this).data('column');
                const col = table.column(columnIndex);
                col.visible(!col.visible());
                $(this).find('input[type="checkbox"]').prop('checked', col.visible());
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest(
                        '#{{ $id }}-export-btn, #{{ $id }}-export-menu').length) {
                    $('#{{ $id }}-export-menu').hide();
                }
                if (!$(e.target).closest(
                        '#{{ $id }}-colvis-btn, #{{ $id }}-colvis-menu').length) {
                    $('#{{ $id }}-colvis-menu').hide();
                }
            });
        });
    </script>
@endpush
