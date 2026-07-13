@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <x-page-header
        title="Edit profile"
        :subtitle="$student->full_name"
        icon="bi-pencil"
        :breadcrumbs="[
            ['label' => 'Opportunities', 'url' => route('student.vacancies.index')],
            ['label' => 'My profile', 'url' => route('my.profile.show')],
            ['label' => 'Edit', 'url' => route('my.profile.edit')],
        ]"
    />
    <x-form-card title="Update profile" :back-url="route('student.vacancies.index')" back-label="Opportunities">
        <form method="POST" action="{{ route('my.profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('students._form', ['student' => $student])
            <button class="btn btn-kiu mt-4" type="submit">Save changes</button>
        </form>
    </x-form-card>
@endsection
