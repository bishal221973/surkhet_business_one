<button class="main-bg border-0 px-3 rounded shadow" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
    <i class="fa fa-plus"></i>
    Add Expense
</button>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">{{ $expense?->id ? 'Edit' : 'Add' }} Expense
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $expense?->id ? route('expense.update', $expense->id) : route('expense.store') }}"
                method="post">
                @csrf
                @method($expense?->id ? 'put' : 'post')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title"
                                value="{{ old('title', $expense?->title) }}" placeholder="Title">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Payment Modes</label>
                            <select class="form-control form-select" name="payment_mode_id">
                                <option value="">Select payment mode</option>
                                @foreach ($paymentModes as $paymentMode)
                                    <option value="{{ $paymentMode->id }}"
                                        {{ old('payment_mode_id', $expense?->payment_mode_id) == $paymentMode->id ? 'selected' : '' }}>
                                        {{ $paymentMode->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Banks</label>
                            <select class="form-control form-select" name="bank_id">
                                <option value="">Select bank</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}"
                                        {{ old('bank_id', $expense?->bank_id) == $bank->id ? 'selected' : '' }}>
                                        {{ $bank->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Expense Head</label>
                            <select class="form-control form-select" name="expense_category_id">
                                <option value="">Select expense head</option>
                                @foreach ($expenseHeads as $expenseHead)
                                    <option value="{{ $expenseHead->id }}"
                                        {{ old('expense_category_id', $expense?->expense_category_id) == $expenseHead->id ? 'selected' : '' }}>
                                        {{ $expenseHead->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-datepicker col="mb-3 col-md-4" required="true"
                            value="{{ old('payment_date', $expense?->payment_date) }}" label="Payment Date" name="payment_date"
                            placeholder="Enter payment date" />



                        <div class="col-md-4 mb-3">
                            <label>Amount</label>
                            <input type="number" step="0.01" class="form-control" name="amount"
                                value="{{ old('amount', $expense?->amount) }}" placeholder="Expense Amount">
                        </div>


                        <x-form.textarea col="mb-3 col-md-12" value="{{ old('description', $expense?->description) }}"
                            label="Remarks" name="description" placeholder="Enter remarks" />
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn main-bg text-white">
                            {{ $expense?->id ? 'Update' : 'Save' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($expense?->id || session('error'))
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
