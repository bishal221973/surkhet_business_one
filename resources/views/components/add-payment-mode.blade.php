<button class="main-bg border-0 px-3 rounded shadow" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
    <i class="fa fa-plus"></i>
    Add Payment Mode
</button>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">{{ $paymentMode?->id ? 'Edit' : 'Add' }}
                    Payment Mode
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form
                action="{{ $paymentMode?->id ? route('paymentMode.update', $paymentMode->id) : route('paymentMode.store') }}"
                method="post">
                @csrf
                @method($paymentMode?->id ? 'put' : 'post')
                <div class="modal-body">
                    <x-form.input col="mb-3" required="true" value="{{ old('name', $paymentMode?->name) }}"
                        label="Payment Mode" name="name" placeholder="Enter payment mode" />
                    <x-form.textarea col="mb-3 col-md-12" value="{{ old('description', $paymentMode?->description) }}"
                        label="Remarks" name="description" placeholder="Enter remarks" />
                        <div class="d-flex justify-content-end mt-3">
                                <button class="btn main-bg text-white">
                                    {{ $paymentMode?->id ? 'Update' : 'Save' }}</button>
                            </div>
                </div>
            </form>
        </div>
    </div>
</div>
@if ($paymentMode?->id)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
                myModal.show();
            });
        </script>
    @endpush
@endif
