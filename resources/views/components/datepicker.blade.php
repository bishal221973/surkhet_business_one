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
    @if ($label)
        <label for="{{ $id ?? $name }}" class="">
            {{ $label }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    @php
        $dateType = App\models\OrganizationSetting::where('key', 'date_type')->first();
    @endphp
    @if ($dateType->value == 'AD Date')
        <input type="date" name="{{ $name }}" id="{{ $id ?? $name }}"
            value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'form-control']) }}>
    @else
          <input type="text" name="{{ $name }}"
            value="{{ old($name, $value) }}" id="nepali-datepicker"  placeholder="Select Date" {{ $attributes->merge(['class' => 'form-control w-100 nepali-datepicker']) }} {{ $required ? 'required' : '' }}/>
    @endif

    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
