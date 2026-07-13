@extends('layouts.app')

@section('title', 'Edit Vacancy')

@section('content')
    <x-page-header
        title="Edit Vacancy"
        :subtitle="$vacancy->title"
        icon="bi-pencil-square"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Vacancies', 'url' => route('vacancies.index')],
            ['label' => $vacancy->title, 'url' => route('vacancies.show', $vacancy)],
            ['label' => 'Edit', 'url' => route('vacancies.edit', $vacancy)],
        ]"
    />

    <x-form-card title="Update vacancy" :back-url="route('vacancies.show', $vacancy)">
        <form method="POST" action="{{ route('vacancies.update', $vacancy) }}">
            @csrf
            @method('PUT')
            @include('vacancies._form', ['vacancy' => $vacancy])
            <div class="d-flex gap-2 mt-4 pt-3 border-top" style="border-color:var(--border)!important;">
                <button class="btn btn-kiu" type="submit"><i class="bi bi-check-lg me-1"></i> Save changes</button>
                <a class="btn btn-kiu-soft" href="{{ route('vacancies.show', $vacancy) }}">Cancel</a>
            </div>
        </form>
    </x-form-card>
@endsection
