<button class="main-bg border-0 px-3 rounded shadow" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
    <i class="fa fa-plus"></i>
    Add Expense Head
</button>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">{{ $expenseCategory?->id ? 'Edit' : 'Add' }}
                    Expense Head
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form
                action="{{ $expenseCategory?->id ? route('expenseCategory.update', $expenseCategory->id) : route('expenseCategory.store') }}"
                method="post">
                @csrf
                @method($expenseCategory?->id ? 'put' : 'post')
                <div class="modal-body">
                    <x-form.input col="mb-3" required="true" value="{{ old('name', $expenseCategory?->name) }}"
                        label="Expense Head" name="name" placeholder="Enter expense head" />
                    <x-form.textarea col="mb-3 col-md-12" value="{{ old('description', $expenseCategory?->description) }}"
                        label="Remarks" name="description" placeholder="Enter remarks" />
                        <div class="d-flex justify-content-end mt-3">
                                <button class="btn main-bg text-white">
                                    {{ $expenseCategory?->id ? 'Update' : 'Save' }}</button>
                            </div>
                </div>
            </form>
        </div>
    </div>
</div>
@if ($expenseCategory?->id)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
                myModal.show();
            });
        </script>
    @endpush
@endif
