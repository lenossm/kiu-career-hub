@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <x-page-header
        title="Edit Task"
        :subtitle="$task->title"
        icon="bi-pencil-square"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Tasks', 'url' => route('tasks.index')],
            ['label' => 'Edit', 'url' => route('tasks.edit', $task)],
        ]"
    />

    <x-form-card title="Update task" :back-url="route('tasks.index')">
        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('PUT')
            @include('tasks._form', ['task' => $task])
            <div class="d-flex gap-2 mt-4 pt-3 border-top" style="border-color:var(--border)!important;">
                <button class="btn btn-kiu" type="submit"><i class="bi bi-check-lg me-1"></i> Save changes</button>
                <a class="btn btn-kiu-soft" href="{{ route('tasks.index') }}">Cancel</a>
            </div>
        </form>
    </x-form-card>
@endsection
