@extends('layouts.app')

@section('title', 'Edit Faculty Profile')

@section('content')
    <x-form-card title="Update faculty profile" :back-url="route('professor.portal')">
        <form method="POST" action="{{ route('professor.profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <x-form-input name="full_name" label="Full name" :value="old('full_name', $professor->full_name)" required />
            <x-form-input name="email" label="Email" type="email" :value="old('email', $professor->email)" required />
            <x-form-input name="department" label="Department" :value="old('department', $professor->department)" required />
            <x-form-textarea name="bio" label="Bio" :value="old('bio', $professor->bio)" :rows="4" />
            <x-form-file name="photo" label="Photo" accept="image/*" />
            <button class="btn btn-kiu mt-3" type="submit">Save</button>
        </form>
    </x-form-card>
@endsection
