@extends('layouts.app')

@section('page-title', 'Email Setting')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
    <li class="breadcrumb-item active" aria-current="page">Email Setting</li>
@endsection

@section('content')
    <div class="container mt-1">
        <div class="row">
            <!-- Sidebar Menu -->
            @include('settings.menu')

            <!-- Main Content -->
            <div class="col-md-9">

                <!-- Preview Section -->
                <div id="organization-preview" class="p-3 mb-3 rounded shadow"
                    style="background-color: #e5e5e5; border:1px solid #ccc">
                    <h4>Send demo email</h4>
                    <form action="{{ route('email.setting.demo.mail') }}" method="post">
                        @csrf
                        <div class="row">
                            <x-form.input required="true" col="mb-3 col-md-6" label="Subject" name="subject"
                                placeholder="Subject" />
                            <x-form.input required="true" col="mb-3 col-md-6" label="To" name="to"
                                placeholder="Receiver's mail" />
                            <x-form.textarea label="Message" name="message" col="mb-3 col-md-12" rows="2"
                                placeholder="Message" />
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Settings Form -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <p>Here you can manage your organization's settings. Changes are reflected in real time above.</p>

                        <form action="{{ route('email.setting.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <x-form.input required="true" col="mb-3 col-md-6" label="Email Provider"
                                    name="email_provider" id="email_provider"
                                    value="{{ $settings->where('key', 'email_provider')->first()?->value }}"
                                    placeholder="Enter email provider" />

                                <x-form.input required="true" col="mb-3 col-md-6" label="Email Host" name="email_host"
                                    id="email_host" value="{{ $settings->where('key', 'email_host')->first()?->value }}"
                                    placeholder="Enter email host" />
                                <x-form.input required="true" col="mb-3 col-md-6" label="Email Port" name="email_port"
                                    id="email_port" value="{{ $settings->where('key', 'email_port')->first()?->value }}"
                                    placeholder="Enter email port" />
                                <x-form.input required="true" col="mb-3 col-md-6" label="Username" name="email_username"
                                    id="email_username"
                                    value="{{ $settings->where('key', 'email_username')->first()?->value }}"
                                    placeholder="Enter username" />
                                <x-form.input type="password" required="true" col="mb-3 col-md-6" label="Password"
                                    name="email_password" id="email_password"
                                    value="{{ $settings->where('key', 'email_password')->first()?->value }}"
                                    placeholder="Enter password" />
                                <x-form.input required="true" col="mb-3 col-md-6" label="Encryption" name="email_encryption"
                                    id="email_encryption"
                                    value="{{ $settings->where('key', 'email_encryption')->first()?->value }}"
                                    placeholder="Enter encryption" />
                                <x-form.input required="true" col="mb-3 col-md-6" label="From Address"
                                    name="email_from_adress" id="email_from_adress"
                                    value="{{ $settings->where('key', 'email_from_adress')->first()?->value }}"
                                    placeholder="Enter from address" />
                                <x-form.input required="true" col="mb-3 col-md-6" label="From Name" name="email_from_name"
                                    id="email_from_name"
                                    value="{{ $settings->where('key', 'email_from_name')->first()?->value }}"
                                    placeholder="Enter from name" />


                            </div>

                            <button type="submit" class="btn btn-success mt-2">Save Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Real-time Preview Script -->
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
