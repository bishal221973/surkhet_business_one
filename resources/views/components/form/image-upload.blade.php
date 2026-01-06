@props([
    'label' => 'Image',
    'name',
    'value' => null,
    'default' => null,
    'height' => 120,
    'col' => 'col-md-6',
    'required' => false,
])

@php
    $uid = uniqid($name . '_');
    $previewId = 'preview_' . $uid;
    $dropId = 'drop_' . $uid;
    $inputId = 'input_' . $uid;

    $originalSrc = $value ? asset('storage/' . $value) : ($default ? asset($default) : '');
@endphp

<div class="{{ $col }}">
    <label class="form-label">{{ $label }} @if($required) <span class="text-danger">*</span> @endif</label>

    <div id="{{ $dropId }}" class="border rounded p-3 text-center mb-2 position-relative image-drop-zone"
        style="cursor:pointer; background:#fafafa;" data-input="{{ $inputId }}" data-preview="{{ $previewId }}"
        data-original="{{ $originalSrc }}">
        <div class="position-relative d-inline-block">
            <img id="{{ $previewId }}" src="{{ $originalSrc }}" class="img-thumbnail"
                style="max-height: {{ $height }}px;">

            <span class="cancel-icon position-absolute top-50 start-50 translate-middle d-none"
                onclick="resetImage(event, this)">
                <i class="fa fa-times"></i>
            </span>
        </div>

        <div class="text-muted small mt-2">
            Drag & drop image here or <strong>click to browse</strong>
        </div>
    </div>

    <input type="file" id="{{ $inputId }}" name="{{ $name }}" accept="image/*" hidden
        {{ $attributes }} onchange="handleImageSelect(event)">

    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
@once
    <script>
        function handleImageSelect(event) {
            const input = event.target;
            const dropZone = document.querySelector(`[data-input="${input.id}"]`);
            const preview = document.getElementById(dropZone.dataset.preview);
            const cancelIcon = dropZone.querySelector('.cancel-icon');

            if (!input.files[0]) return;
            previewFile(input.files[0], preview);
            cancelIcon.classList.remove('d-none');
        }

        function previewFile(file, img) {
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = e => img.src = e.target.result;
            reader.readAsDataURL(file);
        }

        function resetImage(e, icon) {
            e.stopPropagation();

            const dropZone = icon.closest('.image-drop-zone');
            const preview = document.getElementById(dropZone.dataset.preview);
            const input = document.getElementById(dropZone.dataset.input);

            preview.src = dropZone.dataset.original;
            input.value = '';
            icon.classList.add('d-none');
        }

        document.addEventListener('click', e => {
            const dz = e.target.closest('.image-drop-zone');
            if (!dz) return;

            if (!e.target.closest('.cancel-icon')) {
                document.getElementById(dz.dataset.input).click();
            }
        });

        document.addEventListener('dragover', e => e.preventDefault());
        document.addEventListener('drop', e => e.preventDefault());

        document.querySelectorAll('.image-drop-zone').forEach(zone => {

            zone.addEventListener('dragover', e => {
                e.preventDefault();
                zone.classList.add('border-primary');
            });

            zone.addEventListener('dragleave', () => {
                zone.classList.remove('border-primary');
            });

            zone.addEventListener('drop', e => {
                e.preventDefault();
                zone.classList.remove('border-primary');

                const input = document.getElementById(zone.dataset.input);
                const preview = document.getElementById(zone.dataset.preview);
                const cancelIcon = zone.querySelector('.cancel-icon');
                const file = e.dataTransfer.files[0];

                if (file && file.type.startsWith('image/')) {
                    input.files = e.dataTransfer.files;
                    previewFile(file, preview);
                    cancelIcon.classList.remove('d-none');
                }
            });
        });
    </script>
@endonce
