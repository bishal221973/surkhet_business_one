<div class="card shadow-sm">
    <div class="card-body">

        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <x-form.input required="true" col="mb-3 col-md-12" label="Full Name" name="name"
                    value="{{ auth()?->user()?->name }}" placeholder="Enter full name" />

                <x-form.input col="mb-3 col-md-6" label="Email" name="email"
                    value="{{ auth()?->user()?->email }}" placeholder="Enter email" />

                <x-form.input required="true" label="Phone" name="phone"  col="mb-3 col-md-6"
                    value="{{ auth()?->user()?->phone }}" placeholder="Enter phone" />
                    <x-form.image-upload col="col-md-12" label="Profile" name="profile"
                                    :value="auth()->user()->profile" default="images/user.png" />
            </div>

            <button type="submit" class="btn btn-success mt-2">Save Settings</button>
        </form>
    </div>
</div>
