@extends('layouts.app')

@section('page-title', 'Organization Setting')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
    <li class="breadcrumb-item active" aria-current="page">Organization Setting</li>
@endsection

@section('content')
    <div class="container mt-1">
        <div class="row">
            @include('settings.menu')

            <div class="col-md-9">

                <div id="organization-preview" class="p-3 mb-3 rounded shadow"
                    style="background-color: #e5e5e5; border:1px solid #ccc">
                    <div class="d-flex align-items-start gap-3">
                        <img src="{{ asset('images/building.png') }}" class="setting-logo">

                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h4 id="preview-name" class="mb-0 fw-bold text-uppercase">
                                    {{ auth()?->user()?->organization?->name ?? 'Organization Name' }}</h4>
                                <small>VAT/PAN No.: <span
                                        id="preview-vat">{{ auth()?->user()?->organization?->vat_number ?? '123456789' }}</span></small>
                            </div>

                            <div class="d-flex gap-3 mb-1">
                                <span><i class="fa fa-envelope text-primary"></i> <span
                                        id="preview-email">{{ auth()?->user()?->organization?->email ?? 'email@example.com' }}</span></span>
                                <span><i class="fa fa-phone text-primary"></i> <span
                                        id="preview-phone">{{ auth()?->user()?->organization?->phone ?? '+977-9812345678' }}</span></span>
                            </div>

                            <span><i class="fa fa-location-dot text-primary"></i> <span
                                    id="preview-address">{{ auth()?->user()?->organization?->address ?? 'Address here' }}</span></span>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <p>Here you can manage your organization's settings. Changes are reflected in real time above.</p>

                        <form action="{{ route('organization.setting.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <x-form.input required="true" col="mb-3 col-md-6" label="Organization Name" name="name"
                                    id="organization_name" value="{{ auth()?->user()?->organization?->name }}"
                                    placeholder="Enter organization name" />

                                <x-form.input col="mb-3 col-md-6" label="VAT/PAN No." name="vat_number" id="vat_number"
                                    value="{{ auth()?->user()?->organization?->vat_number }}"
                                    placeholder="Enter pan/vat number" />

                                <x-form.input required="true" label="Email" name="email" id="email"
                                    col="mb-3 col-md-6" value="{{ auth()?->user()?->organization?->email }}"
                                    placeholder="Enter email" />

                                <x-form.input required="true" label="Phone" name="phone" id="phone"
                                    value="{{ auth()?->user()?->organization?->phone }}" placeholder="Enter phone number"
                                    col="mb-3 col-md-6" />

                                <x-form.textarea label="Address" name="address" col="mb-3 col-md-12" rows="2"
                                    placeholder="Address" :value="auth()?->user()?->organization?->address" />

                                <x-form.image-upload col="col-md-12" label="Organization Logo" name="logo"
                                    :value="auth()->user()->organization?->logo" default="images/building.png" />
                                <x-form.select required="true" label="Date Type" name="date_type"
                                    placeholder="Select Date Type" :options="[
                                        'AD Date' => 'AD Date',
                                        'BS Date' => 'BS Date',
                                    ]" col="mb-3 col-md-6"
                                    :selected="$settings->where('key', 'date_type')->first()?->value" />
                                <x-form.select required="true" label="Date Format" name="date_format"
                                    placeholder="Select Date Format" :options="[
                                        'd-m-Y' => 'd-m-Y',
                                        'm-d-Y' => 'm-d-Y',
                                        'Y-m-d' => 'Y-m-d',
                                        'd/m/Y' => 'd/m/Y',
                                        'm/d/Y' => 'm/d/Y',
                                        'Y/m/d' => 'Y/m/d',
                                    ]" col="mb-3 col-md-6"
                                    :selected="$settings->where('key', 'date_format')->first()?->value" />


                            </div>

                            <button type="submit" class="btn btn-success mt-2">Save Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const fields = ['organization_name', 'vat_number', 'email', 'phone', 'address'];

        fields.forEach(id => {
            const input = document.getElementById(id);
            const preview = document.getElementById('preview-' + id.replace('_name', '-name'));

            input?.addEventListener('input', () => {
                if (id === 'organization_name') document.getElementById('preview-name').textContent = input
                    .value || '{{ auth()?->user()?->organization?->name ?? 'Organization Name' }}';
                if (id === 'vat_number') document.getElementById('preview-vat').textContent = input.value ||
                    '{{ auth()?->user()?->organization?->vat_number ?? '' }}';
                if (id === 'email') document.getElementById('preview-email').textContent = input.value ||
                    '{{ auth()?->user()?->organization?->email ?? 'organization@email.com' }}';
                if (id === 'phone') document.getElementById('preview-phone').textContent = input.value ||
                    '{{ auth()?->user()?->organization?->phone ?? '+977-9812345678' }}';
                if (id === 'address') document.getElementById('preview-address').textContent = input
                    .value || '{{ auth()?->user()?->organization?->address ?? 'Address' }}';
            });
        });
    </script>
@endsection
