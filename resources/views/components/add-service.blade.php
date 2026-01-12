<button class="main-bg border-0 px-3 rounded shadow" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
    <i class="fa fa-plus"></i>
    Add Service
</button>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">{{ $service?->id ? 'Edit' : 'Add' }}
                    Service
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $service?->id ? route('service.update', $service->id) : route('service.store') }}"
                method="post">
                @csrf
                @method($service?->id ? 'put' : 'post')
                <div class="modal-body">
                    <x-form.input col="mb-3" required="true" value="{{ old('name', $service?->name) }}"
                        label="Service name" name="name" placeholder="Enter service name" />
                    <div class="mb-3">
                        <label for="">Unit</label>

                        <select name="unit_id" class="form-control form-select" id="">
                            <option value="">Select Unit</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}"
                                    {{ old('unit_id', $service?->unit_id) == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-form.input col="mb-3" required="true" value="{{ old('rate', $service?->rate) }}"
                        label="Rate" name="rate" placeholder="Enter rate" />
                        <div class="mb-3">
                        <label for="">Type</label>

                        <select name="type" class="form-control form-select" id="">
                            <option value="Product">Product</option>
                            <option value="Service">Service</option>
                        </select>
                    </div>
                    <x-form.textarea col="mb-3 col-md-12" value="{{ old('description', $service?->description) }}"
                        label="Remarks" name="description" placeholder="Enter remarks" />
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn main-bg text-white">
                            {{ $service?->id ? 'Update' : 'Save' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@if ($service?->id)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
                myModal.show();
            });
        </script>
    @endpush
@endif
