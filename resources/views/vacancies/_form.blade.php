@php
    /** @var \App\Models\Vacancy $vacancy */
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold" for="title">Job Title</label>
        <input
            id="title"
            name="title"
            class="form-control"
            value="{{ old('title', $vacancy->title) }}"
            placeholder="e.g., Frontend Developer Intern"
            required
        >
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold" for="company">Company</label>
        <input
            id="company"
            name="company"
            class="form-control"
            value="{{ old('company', $vacancy->company) }}"
            placeholder="e.g., Codevelop"
            required
        >
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label fw-semibold" for="description">Description</label>
    <textarea
        id="description"
        name="description"
        class="form-control"
        rows="6"
        placeholder="Responsibilities, requirements, and details..."
        required
    >{{ old('description', $vacancy->description) }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold" for="required_skills">Required Skills</label>
    <textarea
        id="required_skills"
        name="required_skills"
        class="form-control"
        rows="3"
        placeholder="e.g., HTML, CSS, JavaScript, React"
        required
    >{{ old('required_skills', $vacancy->required_skills) }}</textarea>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold" for="location">Location</label>
        <input id="location" name="location" class="form-control" value="{{ old('location', $vacancy->location) }}" placeholder="e.g., Remote / Tbilisi" required>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold" for="type">Type</label>
        @php $type = old('type', $vacancy->type); @endphp
        <select id="type" name="type" class="form-select" required>
            <option value="" disabled {{ $type ? '' : 'selected' }}>Select type</option>
            @foreach(['Internship','Part-time','Full-time','Remote'] as $t)
                <option value="{{ $t }}" {{ $type === $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row g-3 mt-0">
    <div class="col-md-6">
        <label class="form-label fw-semibold" for="deadline">Deadline</label>
        <input id="deadline" name="deadline" type="date" class="form-control" value="{{ old('deadline', optional($vacancy->deadline)->format('Y-m-d')) }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold" for="audience">Posted for</label>
        @php $aud = old('audience', $vacancy->audience ?? 'student'); @endphp
        <select id="audience" name="audience" class="form-select" required>
            <option value="student" @selected($aud === 'student')>Students (external & internships)</option>
            <option value="professor" @selected($aud === 'professor')>Professors / TA (internal KIU)</option>
        </select>
        <div class="form-text">Choose who can see and apply to this vacancy.</div>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold" for="status">Status</label>
        @php $current = old('status', $vacancy->status ?? 'pending'); @endphp
        <select id="status" name="status" class="form-select" required>
            <option value="pending" {{ $current === 'pending' ? 'selected' : '' }}>Pending (open)</option>
            <option value="done" {{ $current === 'done' ? 'selected' : '' }}>Done (closed)</option>
        </select>
    </div>
</div>
