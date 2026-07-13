@extends('layouts.app')

@section('title', 'Faculty Profile')

@section('content')
    <x-page-header title="Faculty profile" subtitle="Tell the career office about your department and expertise." icon="bi-person-workspace" />
    <x-form-card title="Professor / TA profile" :back-url="route('professor.portal')">
        <form method="POST" action="{{ route('professor.profile.store') }}" enctype="multipart/form-data">
            @csrf
            <x-form-input name="full_name" label="Full name" :value="old('full_name', $professor->full_name)" required />
            <x-form-input name="email" label="Email" type="email" :value="old('email', $professor->email)" required />
            <x-form-input name="department" label="Department / Faculty" :value="old('department', $professor->department)" required />
            <x-form-textarea name="bio" label="Short bio" :value="old('bio', $professor->bio)" :rows="4" />
            <x-form-file name="photo" label="Photo" accept="image/*" />
            <button class="btn btn-kiu mt-3" type="submit">Continue to portal</button>
        </form>
    </x-form-card>
@endsection
