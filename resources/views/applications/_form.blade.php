@php
    /** @var \App\Models\Application $application */
@endphp

<x-form-textarea
    name="cover_letter"
    label="Cover Letter"
    :value="$application->cover_letter"
    :rows="7"
    required
/>

<div class="mb-3">
    <label class="form-label fw-semibold" for="status">Status</label>
    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
        @foreach(['pending', 'reviewed', 'accepted', 'rejected'] as $status)
            <option value="{{ $status }}" {{ old('status', $application->status) === $status ? 'selected' : '' }}>
                {{ ucfirst($status) }}
            </option>
        @endforeach
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<x-form-file
    name="resume"
    label="Resume (PDF or Word)"
    accept=".pdf,.doc,.docx"
    help="Leave empty to keep the current file."
/>

@if($application->resume_path)
    <div class="mb-3">
        <div class="small text-white-75">Current resume</div>
        <a href="{{ asset('storage/'.$application->resume_path) }}" target="_blank" rel="noopener">Download current file</a>
    </div>
@endif
