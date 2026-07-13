@extends('layouts.app')

@section('title', 'Apply')

@section('content')
    <x-page-header :title="$vacancy->title" :subtitle="$vacancy->company" icon="bi-send" />
    <x-form-card title="Your application" :back-url="route('student.vacancies.index')">
        <form method="POST" action="{{ route('student.apply.store', $vacancy) }}" enctype="multipart/form-data">
            @csrf
            <x-form-textarea name="cover_letter" label="Cover letter" :value="old('cover_letter')" :rows="7" required />
            <x-form-file name="resume" label="Resume (PDF)" accept=".pdf,.doc,.docx" />
            <button class="btn btn-kiu mt-3" type="submit"><i class="bi bi-send me-1"></i> Submit</button>
        </form>
    </x-form-card>
@endsection
