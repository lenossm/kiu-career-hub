@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    @include('students.show', ['student' => $student, 'self' => true])
@endsection
