@props([
    'label' => '',
    'name',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'id' => null,
    'required' => false,
    'col' => '',
])

<div class="{{ $col }}">
    @if($label)
        <label for="{{ $id ?? $name }}" class="">
            {{ $label }}
            @if($required) <span class="text-danger">*</span> @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-control']) }}
    >

    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
