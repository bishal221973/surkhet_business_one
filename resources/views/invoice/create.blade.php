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
                    <x-form.input col="mb-3 col-md-4" required
                        value="{{ old('invoice_number', $invoice?->invoice_number) }}"
                        label="Invoice Number"
                        name="invoice_number" />

                    {{-- Client --}}
                    <div class="col-md-4 mb-3">
                        <label>Client</label>
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
                    <x-datepicker col="mb-3 col-md-4" required
                        value="{{ old('due_date', $invoice?->due_date) }}"
                        label="Due Date"
                        name="due_date" />

                    {{-- Add Service Button --}}
                    <div class="col-12 text-end mb-2">
                        <button type="button" class="btn btn-sm btn-primary"
                            data-bs-toggle="modal" data-bs-target="#serviceModal">
                            + Add Service
                        </button>
                    </div>

                    {{-- Service Table --}}
                    <div class="col-12">
                        <table class="w-100 form-table">
                            <thead class="text-center table-header-bg1">
                                <tr class="table-header-bg1">
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
                        </table>
                    </div>

                    {{-- Sub Total --}}
                    <div class="col-md-4 mb-3">
                        <label>Sub Total</label>
                        <input type="number" readonly class="form-control" id="subTotal" name="sub_total">
                    </div>

                    {{-- Discount --}}
                    <div class="col-md-4 mb-3">
                        <label>Discount</label>
                        <input type="number" class="form-control" id="discount" name="discount"
                            value="0" oninput="computeTotal()">
                    </div>

                    {{-- Net Amount --}}
                    <div class="col-md-4 mb-3">
                        <label>Net Amount</label>
                        <input type="number" readonly class="form-control" id="netAmount" name="net_amount">
                    </div>

                    {{-- VAT --}}
                    <div class="col-md-4 mb-3">
                        <label>VAT</label>
                        <select class="form-control" id="select_vat" onchange="computeTotal()">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    {{-- VAT Amount --}}
                    <div class="col-md-4 mb-3">
                        <label>VAT Amount</label>
                        <input type="number" readonly class="form-control" id="vatAmount" name="vat_amount">
                    </div>

                    {{-- Total --}}
                    <div class="col-md-4 mb-3">
                        <label>Total</label>
                        <input type="number" readonly class="form-control" id="totalAmount" name="total">
                    </div>

                    {{-- Remarks --}}
                    <x-form.textarea col="mb-3 col-md-12"
                        value="{{ old('remarks', $invoice?->remarks) }}"
                        label="Remarks"
                        name="remarks" />

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

{{-- ================= SERVICE MODAL ================= --}}
<div class="modal fade" id="serviceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Service</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row">

                    {{-- Service --}}
                    <div class="col-md-4 mb-2">
                        <label>Service</label>
                        <select id="service_id" class="form-control" onchange="onServiceChange()">
                            <option value="">Select</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}"
                                    data-unit="{{ $service->unit_id }}"
                                    data-rate="{{ $service->rate }}">
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Unit --}}
                    <div class="col-md-2 mb-2">
                        <label>Unit</label>
                        <select id="unit_id" class="form-control">
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Quantity --}}
                    <div class="col-md-2 mb-2">
                        <label>Qty</label>
                        <input type="number" id="quantity" class="form-control" value="1" min="1">
                    </div>

                    {{-- Rate --}}
                    <div class="col-md-2 mb-2">
                        <label>Rate</label>
                        <input type="number" id="rate" class="form-control">
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-2 mb-2">
                        <label>Amount</label>
                        <input type="number" id="amount" class="form-control" readonly>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="addServiceRow()">Add</button>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
let rowIndex = 0;
let editIndex = null;

/* ---------- Auto-fill on service change ---------- */
function onServiceChange() {
    const service = document.getElementById('service_id');
    const selected = service.options[service.selectedIndex];
    if (!selected.value) return;

    document.getElementById('unit_id').value = selected.dataset.unit;
    document.getElementById('rate').value = selected.dataset.rate;
    document.getElementById('quantity').value = 1;

    calcAmount();
}

/* ---------- Calculate amount ---------- */
function calcAmount() {
    let qty = parseFloat(document.getElementById('quantity').value) || 0;
    let rate = parseFloat(document.getElementById('rate').value) || 0;
    document.getElementById('amount').value = (qty * rate).toFixed(2);
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('quantity').addEventListener('input', calcAmount);
    document.getElementById('rate').addEventListener('input', calcAmount);
});

/* ---------- Add / Update Row ---------- */
function addServiceRow() {
    const service = document.getElementById('service_id');
    const unit = document.getElementById('unit_id');
    const qty = document.getElementById('quantity');
    const rate = document.getElementById('rate');
    const amount = document.getElementById('amount');

    if (!service.value) {
        alert('Please select service');
        return;
    }

    const rowId = editIndex !== null ? editIndex : rowIndex;

    const html = `
    <tr data-index="${rowId}">
        <td class="text-center">${rowId + 1}</td>
        <td>
            ${service.options[service.selectedIndex].text}
            <input type="hidden" name="services[${rowId}][service_id]" value="${service.value}">
        </td>
        <td>
            ${unit.options[unit.selectedIndex].text}
            <input type="hidden" name="services[${rowId}][unit_id]" value="${unit.value}">
        </td>
        <td>
            ${rate.value}
            <input type="hidden" name="services[${rowId}][rate]" value="${rate.value}">
        </td>
        <td>
            ${qty.value}
            <input type="hidden" name="services[${rowId}][quantity]" value="${qty.value}">
        </td>
        <td class="amount-cell">
            ${amount.value}
            <input type="hidden" name="services[${rowId}][amount]" value="${amount.value}">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-warning" onclick="editRow(${rowId})">Edit</button>
            <button type="button" class="btn btn-sm btn-danger" onclick="deleteRow(${rowId})">Delete</button>
        </td>
    </tr>`;

    if (editIndex !== null) {
        document.querySelector(`tr[data-index="${editIndex}"]`).outerHTML = html;
        editIndex = null;
    } else {
        document.getElementById('serviceTableBody').insertAdjacentHTML('beforeend', html);
        rowIndex++;
    }

    resetModal();
    recalcSubTotal();
    bootstrap.Modal.getInstance(document.getElementById('serviceModal')).hide();
}

/* ---------- Edit Row ---------- */
function editRow(index) {
    const row = document.querySelector(`tr[data-index="${index}"]`);
    editIndex = index;

    document.getElementById('service_id').value =
        row.querySelector('[name$="[service_id]"]').value;
    document.getElementById('unit_id').value =
        row.querySelector('[name$="[unit_id]"]').value;
    document.getElementById('rate').value =
        row.querySelector('[name$="[rate]"]').value;
    document.getElementById('quantity').value =
        row.querySelector('[name$="[quantity]"]').value;
    document.getElementById('amount').value =
        row.querySelector('[name$="[amount]"]').value;

    new bootstrap.Modal(document.getElementById('serviceModal')).show();
}

/* ---------- Delete Row ---------- */
function deleteRow(index) {
    if (!confirm('Remove this service?')) return;
    document.querySelector(`tr[data-index="${index}"]`).remove();
    recalcSubTotal();
}

/* ---------- Subtotal & Total ---------- */
function recalcSubTotal() {
    let total = 0;
    document.querySelectorAll('.amount-cell').forEach(td => {
        total += parseFloat(td.textContent) || 0;
    });
    document.getElementById('subTotal').value = total.toFixed(2);
    computeTotal();
}

function computeTotal() {
    const sub = parseFloat(document.getElementById('subTotal').value) || 0;
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const vatYes = document.getElementById('select_vat').value === 'Yes';

    const net = sub - discount;
    document.getElementById('netAmount').value = net.toFixed(2);

    const vat = vatYes ? net * 0.13 : 0;
    document.getElementById('vatAmount').value = vat.toFixed(2);

    document.getElementById('totalAmount').value = (net + vat).toFixed(2);
}

/* ---------- Reset Modal ---------- */
function resetModal() {
    document.getElementById('service_id').value = '';
    document.getElementById('quantity').value = 1;
    document.getElementById('rate').value = '';
    document.getElementById('amount').value = '';
}
</script>
@endpush
