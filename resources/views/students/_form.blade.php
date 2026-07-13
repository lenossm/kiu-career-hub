@php
    /** @var \App\Models\Student $student */
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <x-form-input name="full_name" label="Full Name" :value="$student->full_name" required />
    </div>
    <div class="col-md-6">
        <x-form-input name="email" label="Email" type="email" :value="$student->email" required />
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <x-form-input name="faculty" label="Faculty" :value="$student->faculty" required />
    </div>
    <div class="col-md-6">
        <x-form-input name="portfolio_link" label="Portfolio Link" :value="$student->portfolio_link" placeholder="https://..." />
    </div>
</div>

<x-form-textarea name="short_bio" label="Short Bio" :value="$student->short_bio" :rows="4" required />

<x-form-textarea name="skills" label="Skills" :value="$student->skills" :rows="3" required placeholder="e.g., Laravel, JavaScript, SQL" />

<x-form-textarea name="experience" label="Experience" :value="$student->experience" :rows="5" placeholder="Describe projects, internships, responsibilities..." />

<div class="row g-3">
    <div class="col-md-6">
        <x-form-input name="github_link" label="GitHub Link" :value="$student->github_link" placeholder="https://github.com/..." />
    </div>
    <div class="col-md-6">
        <x-form-input name="linkedin_link" label="LinkedIn Link" :value="$student->linkedin_link" placeholder="https://linkedin.com/in/..." />
    </div>
</div>

<x-form-file
    name="photo"
    label="Profile Photo"
    accept="image/jpeg,image/png,image/webp"
    help="Optional. JPG, PNG, or WEBP up to 2 MB."
/>

@if($student->photo_path)
    <div class="mb-3">
        <div class="small text-white-75 mb-2">Current photo</div>
        <img src="{{ asset('storage/'.$student->photo_path) }}" alt="{{ $student->full_name }}" class="rounded" style="max-width: 120px; height: auto;">
    </div>
@endif
