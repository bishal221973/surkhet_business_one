<button class="main-bg border-0 px-3 rounded shadow" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
    <i class="fa fa-plus"></i>
    Add Role
</button>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">{{ $role?->id ? 'Edit' : 'Add' }} role</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $role?->id ? route('role.update', $role->id) : route('role.store') }}" method="post">
                @csrf
                @method($role?->id ? 'put' : 'post')
                <div class="modal-body">
                    <x-form.input required="true" value="{{ old('name', $role?->name) }}" label="Role name" name="name"
                        placeholder="Enter role name" />
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn main-bg text-white">
                            {{ $role?->id ? 'Update' : 'Add' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if($role?->id)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var myModal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
                myModal.show();
            });
        </script>
    @endpush
@endif
