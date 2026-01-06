<button class="main-bg border-0 px-3 rounded shadow" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
    <i class="fa fa-plus"></i>
    Add Fiscalyear
</button>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">{{ $fiscalYear?->id ? 'Edit' : 'Add' }} fiscalyear
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $fiscalYear?->id ? route('fiscalyear.update', $fiscalYear->id) : route('fiscalyear.store') }}"
                method="post">
                @csrf
                @method($fiscalYear?->id ? 'put' : 'post')
                <div class="modal-body">
                    <x-form.input col="mb-3" required="true" value="{{ old('name', $fiscalYear?->name) }}"
                        label="Fiscalyear name" name="name" placeholder="Enter fiscalyear name" />
                    <x-datepicker col="mb-3 w-full" required="true"
                        value="{{ old('start_date', $fiscalYear?->start_date) }}" label="Start Date" name="start_date"
                        placeholder="Enter start date" />
                    <x-datepicker col="mb-3 w-full" required="true"
                        value="{{ old('end_date', $fiscalYear?->end_date) }}" label="End Date" name="end_date"
                        placeholder="Enter end date" />
                    <x-form.select required="true" label="Status" name="is_active" placeholder="Select status"
                        :options="[
                            true => 'True',
                            false => 'False',
                        ]" col="mb-3" :selected="false" />
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn main-bg text-white">
                            {{ $fiscalYear?->id ? 'Update' : 'Save' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@if($fiscalYear?->id)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var myModal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
                myModal.show();
            });
        </script>
    @endpush
@endif
