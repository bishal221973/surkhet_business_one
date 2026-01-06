@props([
    'type' => 'button',
    'variant' => 'primary',   // primary, secondary, danger, success, warning
    'size' => 'md',           // sm, md, lg
    'icon' => null,
    'disabled' => false,
])

@php
$base = 'btn';
$variants = [
    'primary' => 'btn-primary',
    'secondary' => 'btn-secondary',
    'success' => 'btn-success',
    'danger' => 'btn-danger',
    'warning' => 'btn-warning',
];

$sizes = [
    'sm' => 'btn-sm',
    'md' => '',
    'lg' => 'btn-lg',
];
@endphp

<button
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge([
        'class' => trim("$base {$variants[$variant] ?? ''} {$sizes[$size] ?? ''}")
    ]) }}
>
    @if ($icon)
        <i class="{{ $icon }} me-1"></i>
    @endif

    {{ $slot }}
</button>
