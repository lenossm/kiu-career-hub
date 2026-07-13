@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    @include('students._detail', ['student' => $student, 'self' => true])
@endsection
