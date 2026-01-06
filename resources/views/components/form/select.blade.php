@props([
    'label' => null,
    'name',
    'options' => [],     // ['value' => 'Label']
    'selected' => null,
    'placeholder' => null,
    'col' => 'col-md-3',
    'required' => false,
])

<div class="{{ $col }}">
    @if($label)
        <label for="{{ $name }}" class="">{{ $label }} @if($required) <span class="text-danger">*</span> @endif</label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->merge(['class' => 'form-select']) }}
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach($options as $value => $text)
            <option value="{{ $value }}" @selected($selected == $value)>
                {{ $text }}
            </option>
        @endforeach
    </select>

    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
