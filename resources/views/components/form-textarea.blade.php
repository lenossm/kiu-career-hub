@props([
    'name',
    'label',
    'value' => null,
    'rows' => 4,
    'required' => false,
    'placeholder' => null,
])

<div {{ $attributes->merge(['class' => 'mb-3']) }}>
    <label class="form-label fw-semibold" for="{{ $name }}">{{ $label }}</label>
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        class="form-control @error($name) is-invalid @enderror"
        @if($required) required @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
