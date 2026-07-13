@extends('layouts.app')

@section('title', 'Apply')

@section('content')
    <x-form-card title="Apply to {{ $vacancy->title }}" :back-url="route('professor.portal')">
        <form method="POST" action="{{ route('professor.apply.store', $vacancy) }}" enctype="multipart/form-data">
            @csrf
            <x-form-textarea name="cover_letter" label="Cover letter" :value="old('cover_letter')" :rows="7" required />
            <x-form-file name="resume" label="CV (PDF)" accept=".pdf,.doc,.docx" />
            <button class="btn btn-kiu mt-3" type="submit">Submit application</button>
        </form>
    </x-form-card>
@endsection
