@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
    <x-page-header
        title="Career Office Tasks"
        subtitle="Internal to-do list for reviewing applications, contacting companies, and tracking deadlines."
        icon="bi-list-check"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Tasks', 'url' => route('tasks.index')],
        ]"
    >
        <x-slot:actions>
            <a class="btn btn-kiu" href="{{ route('tasks.create') }}"><i class="bi bi-plus-circle me-1"></i> New task</a>
        </x-slot:actions>
        <x-slot:filters>
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <a class="btn btn-kiu-ghost {{ $status === '' ? 'active' : '' }}" href="{{ route('tasks.index', array_filter(['q' => $q])) }}">All</a>
                <a class="btn btn-kiu-ghost {{ $status === 'pending' ? 'active' : '' }}" href="{{ route('tasks.index', array_filter(['status' => 'pending', 'q' => $q])) }}">Pending</a>
                <a class="btn btn-kiu-ghost {{ $status === 'done' ? 'active' : '' }}" href="{{ route('tasks.index', array_filter(['status' => 'done', 'q' => $q])) }}">Done</a>
                <form class="d-flex gap-2 ms-lg-auto flex-grow-1 flex-lg-grow-0" method="GET" action="{{ route('tasks.index') }}" style="min-width:260px;">
                    @if(in_array($status, ['pending', 'done'], true))
                        <input type="hidden" name="status" value="{{ $status }}">
                    @endif
                    <div class="input-group kiu-input-group flex-grow-1">
                        <span class="input-group-text bg-transparent border-0 text-white-65"><i class="bi bi-search"></i></span>
                        <input class="form-control" name="q" value="{{ $q }}" placeholder="Search tasks...">
                    </div>
                    <button class="btn btn-kiu-soft" type="submit">Go</button>
                </form>
            </div>
        </x-slot:filters>
    </x-page-header>

    <div class="kiu-section-card anim-fade-up">
        <div class="table-responsive">
            <table class="table table-dashboard align-middle mb-0">
                <thead>
                <tr>
                    <th>Task</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($tasks as $task)
                    <tr data-task-id="{{ $task->id }}">
                        <td>
                            <div class="fw-semibold table-dashboard-title">{{ $task->title }}</div>
                            <div class="small table-dashboard-muted kiu-clamp-1">{{ $task->description }}</div>
                        </td>
                        <td class="table-dashboard-cell"><i class="bi bi-calendar2-week me-1"></i>{{ $task->deadline->format('M j, Y') }}</td>
                        <td>
                            <span class="kiu-badge {{ $task->status === 'done' ? 'kiu-badge-closed' : 'kiu-badge-open' }}" data-role="status-badge">
                                <i class="bi {{ $task->status === 'done' ? 'bi-check-circle' : 'bi-hourglass-split' }}"></i>
                                {{ $task->status === 'done' ? 'Done' : 'Pending' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex flex-wrap gap-2 justify-content-end">
                                <form method="POST" action="{{ route('tasks.toggleStatus', $task) }}" class="js-toggle-task-status d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-kiu-status-toggle btn-kiu-sm" type="submit" data-role="toggle-button">
                                        {{ $task->status === 'done' ? 'Reopen' : 'Complete' }}
                                    </button>
                                </form>
                                <a class="btn btn-kiu-neutral btn-kiu-sm" href="{{ route('tasks.edit', $task) }}"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="d-inline" onsubmit="return confirm('Delete this task?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-kiu-danger-outline btn-kiu-sm" type="submit"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-0">
                            <x-empty-state icon="bi-list-check" title="No tasks found" description="Add tasks to organize career office work.">
                                <x-slot:action>
                                    <a class="btn btn-kiu" href="{{ route('tasks.create') }}"><i class="bi bi-plus-circle me-1"></i> New task</a>
                                </x-slot:action>
                            </x-empty-state>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <x-pagination-info :paginator="$tasks" class="mt-3" />
@endsection
