<form action="{{ $route }}" onsubmit=" return confirm('Are you sure?')" method="post">
    @csrf
    @method('delete')
    <button class="edit-btn btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
</form>
