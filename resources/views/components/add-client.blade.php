<button class="main-bg border-0 px-3 rounded shadow" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
    <i class="fa fa-plus"></i>
    Add Client
</button>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">{{ $client?->id ? 'Edit' : 'Add' }} Client
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $client?->id ? route('client.update', $client->id) : route('client.store') }}"
                method="post">
                @csrf
                @method($client?->id ? 'put' : 'post')
                <div class="modal-body">
                    <div class="row">
                        <x-form.input col="mb-3 col-md-4" required="true" value="{{ old('name', $client?->name) }}"
                            label="Client name" name="name" placeholder="Enter client name" />

                        <x-form.input col="mb-3 col-md-4" required="true" type="email"
                            value="{{ old('email', $client?->email) }}" label="Client email" name="email"
                            placeholder="Enter client email" />

                        <x-form.input col="mb-3 col-md-4" required="true" value="{{ old('phone', $client?->phone) }}"
                            label="Client phone" name="phone" placeholder="Enter client phone number" />

                        <x-form.select required="true" label="Type" name="type" placeholder="Select Client Type"
                            :options="[
                                'Customer' => 'Customer',
                                'Company' => 'Company',
                            ]" col="mb-3 col-md-4" :selected=" $client?->type ?? 'Customer'" />


                        <x-form.input col="mb-3 col-md-4" required="true"
                            value="{{ old('address', $client?->address) }}" label="Client address" name="address"
                            placeholder="Enter client address" />

                        <x-form.input col="mb-3 col-md-4" value="{{ old('vat_number', $client?->vat_number) }}"
                            label="Client vat_number" name="vat_number" placeholder="Enter client vat number" />

                        <x-form.textarea col="mb-3 col-md-12" value="{{ old('remarks', $client?->remarks) }}"
                            label="Client remarks" name="remarks" placeholder="Enter client remarks" />
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn main-bg text-white">
                            {{ $client?->id ? 'Update' : 'Save' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($client?->id)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
                myModal.show();
            });
        </script>
    @endpush
@endif
