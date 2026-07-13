@props([
    'name',
    'label',
    'accept' => null,
    'help' => null,
])

<div {{ $attributes->merge(['class' => 'mb-3']) }}>
    <label class="form-label fw-semibold" for="{{ $name }}">{{ $label }}</label>
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="file"
        class="form-control @error($name) is-invalid @enderror"
        @if($accept) accept="{{ $accept }}" @endif
    >
    @if($help)
        <div class="form-text">{{ $help }}</div>
    @endif
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
