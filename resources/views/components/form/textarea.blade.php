@props([
    'label' => '',
    'name',
    'value' => '',
    'rows' => 3,
    'placeholder' => '',
    'id' => null,
    'required' => false,
    'col' => 'col-md-12',
])

<div class="mb-3 {{ $col }}">
    @if($label)
        <label for="{{ $id ?? $name }}" class="form-label">
            {{ $label }}
            @if($required) <span class="text-danger">*</span> @endif
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-control']) }}
    >{{ old($name, $value) }}</textarea>

    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
