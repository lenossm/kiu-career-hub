@extends('layouts.app')

@section('title', 'New Task')

@section('content')
    <x-page-header
        title="New Task"
        subtitle="Add an internal career office task with a deadline."
        icon="bi-clipboard-plus"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Tasks', 'url' => route('tasks.index')],
            ['label' => 'Create', 'url' => route('tasks.create')],
        ]"
    />

    <x-form-card title="Task details" :back-url="route('tasks.index')">
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            @include('tasks._form', ['task' => $task])
            <div class="d-flex gap-2 mt-4 pt-3 border-top" style="border-color:var(--border)!important;">
                <button class="btn btn-kiu" type="submit"><i class="bi bi-check-lg me-1"></i> Save task</button>
                <a class="btn btn-kiu-soft" href="{{ route('tasks.index') }}">Cancel</a>
            </div>
        </form>
    </x-form-card>
@endsection
