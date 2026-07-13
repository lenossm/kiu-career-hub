@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <x-page-header title="Student profile" subtitle="Your profile is used when applying to student opportunities." icon="bi-person-plus" />
    <x-form-card title="Student profile" :back-url="route('student.vacancies.index')">
        <form method="POST" action="{{ route('my.profile.store') }}" enctype="multipart/form-data">
            @csrf
            @include('students._form', ['student' => $student])
            <div class="d-flex gap-2 mt-4 pt-3 border-top" style="border-color:var(--border)!important;">
                <button class="btn btn-kiu" type="submit">Save & see my feed</button>
            </div>
        </form>
    </x-form-card>
@endsection
