@extends('layouts.app')

@section('page-title', 'Invoice Management')

@section('breadcrumb')
    <li class="breadcrumb-item active">Invoice Management</li>
@endsection

@section('content')
    <div class="container mt-1">
        <div class="card">
            <form method="POST"
                action="{{ $invoice?->id ? route('invoice.update', $invoice->id) : route('invoice.store') }}">
                @csrf
                @method($invoice?->id ? 'PUT' : 'POST')

                <div class="card-body">
                    <div class="row">

                        {{-- Invoice Number --}}
                        <div class="mb-3 col-md-3">
                            <label for="">Est. Invoice</label>
                            <input type="text" value="{{ $estimated_invoice }}" class="form-control" readonly disabled>
                        </div>

                        <x-form.input col="mb-3 col-md-3" placeholder="Invoice Number"
                            value="{{ old('invoice_number', $invoice?->invoice_number) }}" label="Invoice Number"
                            name="invoice_number" />

                        {{-- Client --}}
                        <div class="col-md-3 mb-3">
                            <label>Client <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="client_id" required>
                                <option value="">Select client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ $invoice?->client_id == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Due Date --}}
                        <x-datepicker col="mb-3 col-md-3" required value="{{ old('due_date', $invoice?->due_date) }}"
                            label="Due Date" name="due_date" />

                        {{-- Service Table --}}
                        <div class="col-12 text-end mb-2 ">
                            <button type="button" class="btn btn-sm btn-primary" onclick="addEmptyRow()">
                                + Add Service
                            </button>
                        </div>
                        <div class="col-12">
                            <table class="w-100 form-table">
                                <thead class="text-center table-header-bg1">
                                    <tr>
                                        <th>#</th>
                                        <th>Service</th>
                                        <th>Unit</th>
                                        <th>Rate</th>
                                        <th>Qty</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="serviceTableBody"></tbody>
                                <tr class="p-0" style="height: 10px;border-bottom: 1px solid #cccccc4e">
                                    <td class="p-0 border-0" colspan="5">
                                        <div class="d-flex justify-content-end">
                                            <small>Sub Total (Rs.)</small>
                                        </div>
                                    </td>
                                    <td colspan="2" class="border-0">
                                        <input type="text" readonly class="form-control py-1 font12" id="subTotal"
                                            name="sub_total" value="0">
                                    </td>
                                </tr>
                                <tr class="p-0" style="height: 10px;border-bottom: 1px solid #cccccc4e">
                                    <td class="p-0 border-0" colspan="5">
                                        <div class="d-flex justify-content-end">
                                            <small>Discount (Rs.)</small>
                                        </div>
                                    </td>
                                    <td colspan="2" class="border-0">
                                        <input type="number" class="form-control py-1 font12" id="discount"
                                            name="discount" value="0" oninput="computeTotal()">
                                    </td>
                                </tr>
                                <tr class="p-0" style="height: 10px;border-bottom: 1px solid #cccccc4e">
                                    <td class="p-0 border-0" colspan="5">
                                        <div class="d-flex justify-content-end">
                                            <small>Net Amount (Rs.)</small>
                                        </div>
                                    </td>
                                    <td colspan="2" class="border-0 p-0">
                                        <input type="number" readonly class="form-control font12 m-0 py-1" id="netAmount"
                                            name="net_amount">
                                    </td>
                                </tr>
                                <tr class="p-0" style="height: 10px;border-bottom: 1px solid #cccccc4e">
                                    <td class="p-0 border-0" colspan="5">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <small>Vat</small>
                                            <input class="form-check-input" type="checkbox" id="vat_check" checked
                                                onchange="computeTotal()">
                                        </div>
                                    </td>
                                    <td colspan="2" class="border-0 p-0">
                                        <input type="number" readonly class="form-control py-1 font12" id="vatAmount"
                                            name="vat_amount">
                                    </td>
                                </tr>
                                <tr class="p-0" style="height: 10px;border-bottom: 1px solid #ccccccaf">
                                    <td class="p-0 border-0" colspan="5">
                                        <div class="d-flex justify-content-end">
                                            <small>Total</small>

                                        </div>
                                    </td>
                                    <td colspan="2" class="border-0 p-0">
                                        <input type="number" readonly class="form-control py-1 font12" id="totalAmount"
                                            name="total">
                                    </td>
                                </tr>
                            </table>
                        </div>





                        {{-- Remarks --}}
                        <x-form.textarea col="mb-3 mt-3 col-md-12" value="{{ old('remarks', $invoice?->remarks) }}"
                            label="Remarks" name="remarks" />

                    </div>

                    <div class="text-end mt-3">
                        <button class="btn main-bg text-white">
                            {{ $invoice?->id ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        let rowIndex = 0;
        addEmptyRow();
        /* ---------- Add Empty Editable Row ---------- */
        function addEmptyRow() {
            const html = `
    <tr data-row="${rowIndex}">
        <td class="text-center">${rowIndex + 1}</td>

        <td style="width: 200px">
            <select name="services[${rowIndex}][service_id]"
                class="form-control service-select"
                onchange="onServiceChange(this, ${rowIndex})">
                <option value="">Select</option>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}"
                        data-unit="{{ $service->unit_id }}"
                        data-rate="{{ $service->rate }}">
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>
        </td>

        <td style="width: 125px">
            <select name="services[${rowIndex}][unit_id]"
                class="form-control unit-select">
                <option value="">Select</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
        </td>

        <td style="width: 135px">
            <input type="number"
                name="services[${rowIndex}][rate]"
                class="form-control rate-input"
                oninput="recalcRow(${rowIndex})">
        </td>

        <td style="width: 115px">
            <input type="number"
                name="services[${rowIndex}][quantity]"
                class="form-control qty-input"
                value="1" min="1"
                oninput="recalcRow(${rowIndex})">
        </td >

        <td style="width: 150px">
            <input type="number"
                name="services[${rowIndex}][amount]"
                class="form-control amount-input"
                readonly>
        </td>

        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger"
                onclick="removeRow(${rowIndex})">
                Delete
            </button>
        </td>
    </tr>`;

            document.getElementById('serviceTableBody')
                .insertAdjacentHTML('beforeend', html);

            rowIndex++;
        }

        /* ---------- Service Change ---------- */
        function onServiceChange(select, index) {
            const row = document.querySelector(`tr[data-row="${index}"]`);
            const selected = select.options[select.selectedIndex];

            if (!selected.value) return;

            row.querySelector('.unit-select').value = selected.dataset.unit;
            row.querySelector('.rate-input').value = selected.dataset.rate;
            row.querySelector('.qty-input').value = 1;

            recalcRow(index);
        }

        /* ---------- Recalculate Row ---------- */
        function recalcRow(index) {
            const row = document.querySelector(`tr[data-row="${index}"]`);
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const rate = parseFloat(row.querySelector('.rate-input').value) || 0;

            row.querySelector('.amount-input').value = (qty * rate).toFixed(2);
            recalcTotals();
        }

        /* ---------- Remove Row ---------- */
        function removeRow(index) {
            document.querySelector(`tr[data-row="${index}"]`).remove();
            recalcTotals();
        }

        /* ---------- Totals ---------- */
        function recalcTotals() {
            let subTotal = 0;
            document.querySelectorAll('.amount-input').forEach(el => {
                subTotal += parseFloat(el.value) || 0;
            });

            document.getElementById('subTotal').value = subTotal.toFixed(2);
            computeTotal();
        }

        function computeTotal() {
            const sub = parseFloat(document.getElementById('subTotal').value) || 0;
            const discount = parseFloat(document.getElementById('discount').value) || 0;
            // const vatYes = document.getElementById('select_vat').value === 'Yes';
            const vatYes = document.getElementById('vat_check').checked;
            const net = sub - discount;
            document.getElementById('netAmount').value = net.toFixed(2);

            const vat = vatYes ? net * 0.13 : 0;
            document.getElementById('vatAmount').value = vat.toFixed(2);

            document.getElementById('totalAmount').value = (net + vat).toFixed(2);
        }
    </script>
@endpush
