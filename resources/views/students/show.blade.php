@extends('layouts.app')

@section('title', $student->full_name)

@section('content')
    @include('students._detail', ['student' => $student, 'self' => $self ?? false])
@endsection
