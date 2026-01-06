<div class="mb-3 col-md-6">
    <label class="form-label">Organization Logo</label>

    <!-- Preview -->
    <div class="mb-2">
        <img
            id="logoPreview"
            src="{{ auth()->user()->organization?->logo
                    ? asset('storage/' . auth()->user()->organization->logo)
                    : asset('images/building.png') }}"
            class="img-thumbnail"
            style="max-height:120px;"
        >
    </div>

    <!-- File Input -->
    <input
        type="file"
        name="logo"
        class="form-control"
        accept="image/*"
        onchange="previewLogo(event)"
    >
</div>
<script>
function previewLogo(event) {
    const input = event.target;
    const preview = document.getElementById('logoPreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>
