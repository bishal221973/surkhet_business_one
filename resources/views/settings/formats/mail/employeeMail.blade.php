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


                <!-- Settings Form -->
                @include('settings.formats.mail.menu')

                @php
                    $employeWelcomeMail=$formats->where('type',request()->format)->first();
                @endphp

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card shadow-sm mt-2">
                            <div class="card-body">
                                <form action="{{ route('employee.welcome.mail.format.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="{{ request()->format }}">
                                    <x-form.input required="true" col="mb-3 col-md-12" label="Subject" name="subject"
                                        placeholder="Subject" value="{{ $employeWelcomeMail?->subject }}"/>

                                    <x-form.textarea label="Message" id="mailFormat" name="body" col="mb-3 col-md-12" rows="6"
                                        placeholder="Message" value="{!!   $employeWelcomeMail?->body !!}"/>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button class="btn btn-primary">Save</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <b>Send Demo mail</b>
                                <form action="{{ route('send.demo.mail') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="{{ request()->format }}">
                                     <x-form.input required="true" col="mb-3 col-md-12" label="To" name="to"
                                        placeholder="Email" />

                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-primary">Send</button>
                                        </div>
                                </form>
                            </div>
                        </div>

                         <div class="card mt-2">
                            <div class="card-body">

                                <ul>
                                    <li style="background-color: #cccccc94" class="px-3 py-1 rounded mb-2">
                                        <b>
                                            @php
                                                echo "{{ company_name  }}";
                                            @endphp
                                        </b>
                                        <small class="d-block">Company Name</small>
                                    </li>
                                     <li style="background-color: #cccccc94" class="px-3 py-1 rounded mb-2">
                                        <b>
                                            @php
                                                echo "{{ company_email   }}";
                                            @endphp
                                        </b>
                                        <small class="d-block">Company Email</small>
                                    </li>

                                    <li style="background-color: #cccccc94" class="px-3 py-1 rounded mb-2">
                                        <b>
                                            @php
                                                echo "{{ company_address   }}";
                                            @endphp
                                        </b>
                                        <small class="d-block">Company Address</small>
                                    </li>

                                     <li style="background-color: #cccccc94" class="px-3 py-1 rounded mb-2">
                                        <b>
                                            @php
                                                echo "{{ employee_name    }}";
                                            @endphp
                                        </b>
                                        <small class="d-block">Employee Name</small>
                                    </li>
                                    <li style="background-color: #cccccc94" class="px-3 py-1 rounded mb-2">
                                        <b>
                                            @php
                                                echo "{{ joining_date     }}";
                                            @endphp
                                        </b>
                                        <small class="d-block">Joining Date</small>
                                    </li>
                                    <li style="background-color: #cccccc94" class="px-3 py-1 rounded mb-2">
                                        <b>
                                            @php
                                                echo "{{ email     }}";
                                            @endphp
                                        </b>
                                        <small class="d-block">Employee auth email</small>
                                    </li>
                                    <li style="background-color: #cccccc94" class="px-3 py-1 rounded mb-2">
                                        <b>
                                            @php
                                                echo "{{ password }}";
                                            @endphp
                                        </b>
                                        <small class="d-block">Employee auth password</small>
                                    </li>
                                </ul>

                                <i>
                                    <b class="text-danger">Note : </b>
                                    <small>All keywords are case sensitive and must be in double quotes. These keywords will be replaced with actual values.</small>
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
