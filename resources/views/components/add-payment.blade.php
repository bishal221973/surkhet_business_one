<button class="main-bg border-0 px-3 rounded shadow" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
    <i class="fa fa-plus"></i>
    Add Payment
</button>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Make Payment
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('payment.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="mb-3 col-md-4">
                            <label for="">Invoice</label>
                            <select name="invoice_id" id="invoiceSelect" class="form-control form-select">
                                <option value="">Select invoice</option>
                                @foreach ($invoices as $invoice)
                                    <option value="{{ $invoice->id }}" data-client="{{ $invoice->client_id }}"
                                        data-payable="{{ $invoice->payable_amount }}">
                                        {{ $invoice->invoice_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="">Client</label>
                            <input type="hidden" name="client_id" id="clientInput">
                            <select disabled id="clientSelect" class="form-control form-select">
                                <option value="">Select clients</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="">Payment Mode</label>
                            <select name="payment_mode_id" class="form-control form-select">
                                <option value="">Select payment mode</option>
                                @foreach ($paymentModes as $paymentMode)
                                    <option value="{{ $paymentMode->id }}">{{ $paymentMode->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="">Bank</label>
                            <select name="bank_id" class="form-control form-select">
                                <option value="">Select bank</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-datepicker col="mb-3 col-md-4" required="true" value="{{ old('payment_date') }}"
                            label="Payment date" name="payment_date" placeholder="Payment Date" />
                        <div class="mb-3 col-md-4">
                            <label for="">Amount</label>
                            <input type="number" step="0.01" class="form-control" name="amount" id="amount">
                        </div>
                        <x-form.textarea col="mb-3 col-md-12" value="{{ old('remarks') }}" label="Client remarks"
                            name="remarks" placeholder="Enter client remarks" />
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn main-bg text-white">
                            Receive Payment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.getElementById('invoiceSelect').addEventListener('change', function() {
            const clientId = this.selectedOptions[0].dataset.client; // get client_id
            const amount = this.selectedOptions[0].dataset.payable; // get client_id
            console.log(this.selectedOptions[0])
            const clientSelect = document.getElementById('clientSelect');
            clientSelect.value = clientId || ""; // select client
            document.getElementById('clientInput').value = clientId || "";
            document.getElementById('amount').value = amount || "";
        });
    </script>
@endpush
