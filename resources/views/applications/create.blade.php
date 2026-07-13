@extends('layouts.app')

@section('title', 'Apply')

@section('content')
    <x-page-header
        title="Submit Application"
        :subtitle="$vacancy->title.' · '.$vacancy->company"
        icon="bi-send"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Vacancies', 'url' => route('vacancies.index')],
            ['label' => $vacancy->title, 'url' => route('vacancies.show', $vacancy)],
            ['label' => 'Apply', 'url' => route('vacancies.apply', $vacancy)],
        ]"
    />

    @if($students->isEmpty())
        <div class="kiu-card">
            <x-empty-state
                icon="bi-person-plus"
                title="No student profiles yet"
                description="Students register and create their own profiles. Once they exist, you can record applications on their behalf here."
            >
                <x-slot:action>
                    <a class="btn btn-kiu" href="{{ route('students.index') }}"><i class="bi bi-people me-1"></i> View students</a>
                </x-slot:action>
            </x-empty-state>
        </div>
    @else
        <x-form-card title="Application form" :back-url="route('vacancies.show', $vacancy)" subtitle="{{ $vacancy->type }} · {{ $vacancy->location }}">
            <form method="POST" action="{{ route('vacancies.apply.store', $vacancy) }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="student_id"><i class="bi bi-person me-1"></i> Student profile</label>
                    <select id="student_id" name="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                        <option value="" disabled {{ old('student_id') ? '' : 'selected' }}>Select a profile</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ (string)old('student_id') === (string)$student->id ? 'selected' : '' }}>
                                {{ $student->full_name }} — {{ $student->faculty }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <x-form-textarea name="cover_letter" label="Cover letter" :value="old('cover_letter')" :rows="7" required placeholder="Explain why this student is a good fit..." />
                <x-form-file name="resume" label="Resume (PDF or Word)" accept=".pdf,.doc,.docx" help="Optional · up to 4 MB" />

                <div class="d-flex gap-2 mt-4 pt-3 border-top" style="border-color:var(--border)!important;">
                    <button class="btn btn-kiu" type="submit"><i class="bi bi-send me-1"></i> Submit application</button>
                    <a class="btn btn-kiu-soft" href="{{ route('vacancies.show', $vacancy) }}">Cancel</a>
                </div>
            </form>
        </x-form-card>
    @endif
@endsection
