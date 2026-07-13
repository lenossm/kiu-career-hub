@extends('layouts.app')

@section('title', 'Edit Application')

@section('content')
    <x-page-header
        title="Edit Application"
        :subtitle="$application->student->full_name.' · '.$application->vacancy->title"
        icon="bi-pencil-square"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Applications', 'url' => route('applications.index')],
            ['label' => 'Details', 'url' => route('applications.show', $application)],
            ['label' => 'Edit', 'url' => route('applications.edit', $application)],
        ]"
    />

    <x-form-card title="Update application" :back-url="route('applications.show', $application)">
        <form method="POST" action="{{ route('applications.update', $application) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('applications._form', ['application' => $application])
            <div class="d-flex gap-2 mt-4 pt-3 border-top" style="border-color:var(--border)!important;">
                <button class="btn btn-kiu" type="submit"><i class="bi bi-check-lg me-1"></i> Save changes</button>
                <a class="btn btn-kiu-soft" href="{{ route('applications.show', $application) }}">Cancel</a>
            </div>
        </form>
    </x-form-card>
@endsection
