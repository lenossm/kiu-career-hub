@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'placeholder' => null,
])

<div {{ $attributes->merge(['class' => 'mb-3']) }}>
    <label class="form-label fw-semibold" for="{{ $name }}">{{ $label }}</label>
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        class="form-control @error($name) is-invalid @enderror"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
    >
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
