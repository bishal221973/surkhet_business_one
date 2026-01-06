@extends('layouts.app')

@section('page-title', 'User Account Setting')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
    <li class="breadcrumb-item active" aria-current="page">User Account Setting</li>
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
                    <div class="d-flex align-items-start gap-3">
                        <img src="{{ auth()->user() && auth()->user()->profile
                            ? asset('storage/' . auth()->user()->profile)
                            : asset('images/user.png') }}"
                            class="setting-profile">

                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h4 id="preview-name" class="mb-0 fw-bold text-uppercase">
                                    {{ auth()?->user()?->name ?? '' }} ({{ auth()->user()->roles[0]?->name }})</h4>
                            </div>

                            <div class="d-flex gap-3 mb-1">
                                <span><i class="fa fa-envelope text-primary"></i> <span
                                        id="preview-email">{{ auth()?->user()?->email ?? 'email@example.com' }}</span></span>
                                <span><i class="fa fa-phone text-primary"></i> <span
                                        id="preview-phone">{{ auth()?->user()?->phone ?? '' }}</span></span>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Settings Form -->
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link " id="pills-timeline-tab" data-bs-toggle="pill" data-bs-target="#pills-timeline"
                            type="button" role="tab" aria-controls="pills-home" aria-selected="true">Timeline</button>
                    </li>


                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                        aria-labelledby="pills-profile-tab">
                        @include('settings.myprofile')
                    </div>
                    <div class="tab-pane fade" id="pills-timeline" role="tabpanel" aria-labelledby="pills-timeline-tab">
                        <div class="card card-body">
                            @include('settings.timeline')
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>

    <!-- Real-time Preview Script -->
    {{-- <script>
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
    </script> --}}
@endsection
