<button class="bg-transparent border-0" style="color: blue" data-bs-target="#invoiceModalToggle" data-bs-toggle="modal">
    <small>{{ $invoice?->invoice_number }}</small>
</button>


<div class="modal fade" id="invoiceModalToggle" aria-hidden="true" aria-labelledby="invoiceModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0 overflow-hidden">
                <div class="invoice-header">
                    <div class="d-flex justify-content-between">
                        <div class="block">
                            <div class="d-flex gap-3 align-items-center">
                                <img src="{{ asset('images/logo.png') }}" class="invoice-logo" alt="">
                                <div class="invoice-company-name pt-2">
                                    <h5>Surkhet Business One</h5>
                                    <small>All in one</small>
                                </div>
                            </div>

                            <div class="block mt-3">
                                <b class="d-block text-white">Nepalgunj, Banke, Nepal</b>
                                <small class="d-block text-white-gray">VAT Number : 09899088899</small>
                                <small class="d-block text-white-gray">Tel : +977-123456789</small>
                                <small class="d-block text-white-gray">Email : demo@gmail.com</small>
                            </div>
                        </div>
                        <div class="d-block">
                            <h1 class="text-uppercase text-white">Invoice</h1>
                            <span class="d-block">
                                <span class="text-white">Invoice Number : <span
                                        class="text-white-gray">{{ $invoice?->invoice_number }}</span></span>
                            </span>

                            <div class="mt-3">
                                <span class="d-block">
                                    <span class="text-white">Invoice Date : <span
                                            class="text-white-gray">{{ Carbon\Carbon::parse($invoice?->invoice_date)->format('Y-m-d') }}</span></span>
                                </span>
                                <span class="d-block">
                                    <span class="text-white">Due Date : <span
                                            class="text-white-gray">{{ $invoice?->due_date }}</span></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-white">
                    <b class="text-uppercase d-block" style="color:var(--primary)">Billed To</b>

                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="d-block invoice-client">
                                {{ $invoice->client->name }}
                            </span>
                            @if ($invoice->client?->address)
                                <span class="d-block invoice-client">
                                    {{ $invoice->client?->address }}
                                </span>
                            @endif
                        </div>
                        <div>

                            <span class="d-block invoice-client">
                                {{ $invoice->client?->phone }}
                            </span>
                            <span class="d-block invoice-client">
                                {{ $invoice->client?->email }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-3">
                    <table class="w-100 invoice-table">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Particulars</th>
                                <th>Qty</th>
                                <th>Rate</th>
                                <th>Amount</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td>Subtotal</td>
                                <td>Rs. 20000</td>
                            </tr>
                             <tr>
                                <td colspan="3"></td>
                                <td>Discount</td>
                                <td>Rs. 200</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>Net Amount</td>
                                <td>Rs. 19800</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>Vat</td>
                                <td>Rs. 200</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>Total Amount</td>
                                <td>
                                    <div class="totalAmt">
                                        Rs. 20000
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <hr>
                    <div class="d-flex justify-content-between">
                        <div>
                            <b>Thankyou for choosing us.</b>
                        </div>
                        <div class="d-flex gap-3">
                            <div class="d-flex">
                                <b>Email:</b>
                                <span>demo@gmail.com</span>
                            </div>
                            <div class="d-flex">
                                <b>Tel:</b>
                                <span>987654321</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
