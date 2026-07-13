@extends('layouts.app')

@section('title', 'Add Vacancy')

@section('content')
    <x-page-header
        title="Add Vacancy"
        subtitle="Create a new career opportunity for KIU students."
        icon="bi-plus-circle"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Vacancies', 'url' => route('vacancies.index')],
            ['label' => 'Create', 'url' => route('vacancies.create')],
        ]"
    />

    <x-form-card title="Vacancy details" :back-url="route('vacancies.index')">
        <form method="POST" action="{{ route('vacancies.store') }}">
            @csrf
            @include('vacancies._form', ['vacancy' => $vacancy])
            <div class="d-flex gap-2 mt-4 pt-3 border-top" style="border-color:var(--border)!important;">
                <button class="btn btn-kiu" type="submit"><i class="bi bi-check-lg me-1"></i> Create vacancy</button>
                <a class="btn btn-kiu-soft" href="{{ route('vacancies.index') }}">Cancel</a>
            </div>
        </form>
    </x-form-card>
@endsection
