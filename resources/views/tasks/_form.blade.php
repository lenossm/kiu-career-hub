@php
    /** @var \App\Models\Task $task */
@endphp

<div class="mb-3">
    <label class="form-label fw-semibold" for="title">Title</label>
    <input id="title" name="title" class="form-control" value="{{ old('title', $task->title) }}" required
           placeholder="e.g., Finish Laravel CRUD midterm">
</div>

<div class="mb-3">
    <label class="form-label fw-semibold" for="description">Description</label>
    <textarea id="description" name="description" class="form-control" rows="6" required
              placeholder="Write a clear task description...">{{ old('description', $task->description) }}</textarea>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold" for="deadline">Deadline</label>
        <input id="deadline" name="deadline" type="date" class="form-control"
               value="{{ old('deadline', optional($task->deadline)->format('Y-m-d')) }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold" for="status">Status</label>
        @php $current = old('status', $task->status ?? 'pending'); @endphp
        <select id="status" name="status" class="form-select" required>
            <option value="pending" {{ $current === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="done" {{ $current === 'done' ? 'selected' : '' }}>Done</option>
        </select>
    </div>
</div>

