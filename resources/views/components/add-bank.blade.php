<button class="main-bg border-0 px-3 rounded shadow" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
    <i class="fa fa-plus"></i>
    Add Bank
</button>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">{{ $bank?->id ? 'Edit' : 'Add' }} bank
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $bank?->id ? route('bank.update', $bank->id) : route('bank.store') }}"
                method="post">
                @csrf
                @method($bank?->id ? 'put' : 'post')
                <div class="modal-body">
                    <x-form.input col="mb-3" required="true" value="{{ old('name', $bank?->name) }}"
                        label="Bank name" name="name" placeholder="Enter bank name" />
                    <x-form.input col="mb-3" required="true" value="{{ old('balance', $bank?->balance) }}"
                        label="Balance" name="balance" placeholder="Enter balance" />

                    <x-form.textarea col="mb-3 col-md-12" value="{{ old('description', $bank?->description) }}"
                        label="Remarks" name="description" placeholder="Enter remarks" />
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn main-bg text-white">
                            {{ $bank?->id ? 'Update' : 'Save' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@if ($bank?->id)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
                myModal.show();
            });
        </script>
    @endpush
@endif
