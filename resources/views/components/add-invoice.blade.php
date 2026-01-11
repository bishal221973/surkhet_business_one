<button class="main-bg border-0 px-3 rounded shadow" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
    <i class="fa fa-plus"></i>
    Add Invoice
</button>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">{{ $invoice?->id ? 'Edit' : 'Add' }} Invoice
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $invoice?->id ? route('invoice.update', $invoice->id) : route('invoice.store') }}"
                method="post">
                @csrf
                @method($invoice?->id ? 'put' : 'post')
                <div class="modal-body">
                    <div class="row">
                        <x-form.input col="mb-3 col-md-4" required="true"
                            value="{{ old('invoice_number', $invoice?->invoice_number) }}" label="Invoice Number"
                            name="invoice_number" placeholder="Enter invoice number" />

                        <div class="col-md-4 mb-3">
                            <label>Client</label>
                            <select class="form-control form-select" name="client_id">
                                <option value="">Select client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}"
                                        {{ $invoice?->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-datepicker col="mb-3 col-md-4" required="true"
                            value="{{ old('due_date', $invoice?->due_date) }}" label="Due Date" name="due_date"
                            placeholder="Enter due date" />

                        <div class="col-md-4 mb-3">
                            <label>Sub Total</label>
                            <input type="number" step="0.01" class="form-control" name="sub_total"
                                value="{{ old('sub_total', $invoice?->sub_total) }}" placeholder="Total Amount"
                                id="subTotal" oninput="computeTotal()">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Discount</label>
                            <input type="number" step="0.01" class="form-control" name="discount"
                                value="{{ old('discount', $invoice?->discount) ?? 0 }}" placeholder="Discount Amount"
                                id="discount" oninput="computeTotal()" >
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Net Amount</label>
                            <input type="number" readonly step="0.01" class="form-control" name="net_amount"
                                value="{{ old('net_amoun', $invoice?->net_amount) }}" placeholder="Net Amount"
                                id="netAmount">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Vat</label>
                            <select class="form-control form-select" id="select_vat" onchange="computeTotal()">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Vat Amount</label>
                            <input type="text" name="vat_amount"
                                        class="form-control" readonly id="vatAmount"
                                        value="{{ old('vat_amount', $invoice?->vat_amount) ?? 0 }}">
                        </div>


                        <div class="col-md-4 mb-3">
                            <label>Total Amount</label>
                            <input type="text" id="totalAmount" class="form-control" name="total"
                                value="{{ old('total', $invoice?->total) }}" readonly placeholder="Total Amount">
                        </div>

                        <x-form.textarea col="mb-3 col-md-12" value="{{ old('remarks', $invoice?->remarks) }}"
                            label="Remarks" name="remarks" placeholder="Enter client remarks" />
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn main-bg text-white">
                            {{ $invoice?->id ? 'Update' : 'Save' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($invoice?->id)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
                myModal.show();
            });
        </script>
    @endpush
@endif

@push('scripts')
    <script>
        function computeTotal() {
            let subTotal = document.getElementById('subTotal').value;
            let discount = document.getElementById("discount").value || 0;
            let vat = document.getElementById("select_vat");
            let netAmount = subTotal - discount;

            document.getElementById("netAmount").value = Number(netAmount).toFixed(2);

            let vatAmount = 0;
            if (vat.value == "Yes") {
                vatAmount = (netAmount * 13) / 100;
            }
            document.getElementById("vatAmount").value = Number(vatAmount).toFixed(2);
            document.getElementById('totalAmount').value = Number(Number(netAmount) + Number(vatAmount)).toFixed(2);
        }
    </script>
@endpush
