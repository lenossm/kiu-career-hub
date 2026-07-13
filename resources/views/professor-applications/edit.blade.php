@extends('layouts.app')

@section('title', 'Edit Faculty Application')

@section('content')
    <x-page-header
        title="Edit Faculty Application"
        :subtitle="$application->professor->full_name.' · '.$application->vacancy->title"
        icon="bi-pencil-square"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Applications', 'url' => route('applications.index', ['tab' => 'faculty'])],
            ['label' => 'Details', 'url' => route('professor-applications.show', $application)],
            ['label' => 'Edit', 'url' => route('professor-applications.edit', $application)],
        ]"
    />

    <x-form-card title="Update faculty application" :back-url="route('professor-applications.show', $application)">
        <form method="POST" action="{{ route('professor-applications.update', $application) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Cover letter</label>
                <textarea class="form-control kiu-input" name="cover_letter" rows="6" required>{{ old('cover_letter', $application->cover_letter) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select class="form-select kiu-input" name="status" required>
                    @foreach(['pending', 'reviewed', 'accepted', 'rejected'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $application->status) === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Replace resume (optional)</label>
                <input class="form-control kiu-input" type="file" name="resume" accept=".pdf,.doc,.docx">
            </div>
            <div class="d-flex gap-2 mt-4 pt-3 border-top" style="border-color:var(--border)!important;">
                <button class="btn btn-kiu" type="submit"><i class="bi bi-check-lg me-1"></i> Save changes</button>
                <a class="btn btn-kiu-soft" href="{{ route('professor-applications.show', $application) }}">Cancel</a>
            </div>
        </form>
    </x-form-card>
@endsection
