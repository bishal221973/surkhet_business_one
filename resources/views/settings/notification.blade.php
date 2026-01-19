@extends('layouts.app')

@section('page-title', 'Notification Setting')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
    <li class="breadcrumb-item active" aria-current="page">Notification Setting</li>
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
                    style="background-color: #fff; border:1px solid #ccc">
                    <form action="{{ route('notification.setting.store') }}" method="post">
                        @csrf
                        <div class="row px-3">
                            <div class="form-check col-md-12">
                                <input class="form-check-input" type="checkbox" name="employee_welcome_mail"
                                    id="send_welcome_email" value="1"
                                    {{ optional($settings->where('notification', 'employee_welcome_mail')->first())->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="send_welcome_email">
                                    Send Welcome Email to Employee
                                </label>
                            </div>
                            <div class="form-check col-md-12">
                                <input class="form-check-input" type="checkbox" name="client_welcome_mail"
                                    id="send_welcome_email" value="1"
                                    {{ optional($settings->where('notification', 'client_welcome_mail')->first())->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="send_welcome_email">
                                    Send Welcome Email to Client
                                </label>
                            </div>
                            <div class="form-check col-md-12">
                                <input class="form-check-input" type="checkbox" name="invoice_created_mail"
                                    id="send_welcome_email" value="1"
                                    {{ optional($settings->where('notification', 'invoice_created_mail')->first())->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="send_welcome_email">
                                    Send Invoice Created Mail
                                </label>
                            </div>
                            <div class="form-check col-md-12">
                                <input class="form-check-input" type="checkbox" name="payment_received_mail"
                                    id="send_welcome_email" value="1"
                                    {{ optional($settings->where('notification', 'payment_received_mail')->first())->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="send_welcome_email">
                                    Send Payment Received Mail
                                </label>
                            </div>
                            <div class="form-check col-md-12">
                                <input class="form-check-input" type="checkbox" name="upcoming_due_mail"
                                    id="send_welcome_email" value="1"
                                    {{ optional($settings->where('notification', 'upcoming_due_mail')->first())->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="send_welcome_email">
                                    Send Upcomming Dues Mail
                                </label>
                            </div>
                            <div class="form-check col-md-12">
                                <input class="form-check-input" type="checkbox" name="overdues_mail" id="send_welcome_email"
                                    value="1"
                                    {{ optional($settings->where('notification', 'overdues_mail')->first())->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="send_welcome_email">
                                    Send Overdues Mail
                                </label>
                            </div>

                            <div class="col-md-12 mt-3 p-0 mb-3">
                                <label class="m-0 p-0">Send auto notification at</label>
                                @php
                                    $time=App\Models\OrganizationSetting::where('organization_id',organization()->id)->where('key','auto_notify')->first()?->value ?? '10:00';
                                @endphp
                                <input type="time" class="form-control" name="auto_notify" style="width: 170px" value="{{ $time }}">
                            </div>
                            <div class="col-12 d-flex justify-content-start p-0">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
@endsection
