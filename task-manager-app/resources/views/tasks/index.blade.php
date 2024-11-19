@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 bg-light">
    <div class="container">
        <!-- Header Section -->
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold text-primary mb-0">
                    <i class="fas fa-tasks me-2"></i>Task Management
                </h1>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('tasks.export') }}" class="btn btn-success btn-lg me-2 shadow-sm">
                    <i class="fas fa-download me-2"></i>Export to CSV
                </a>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="fas fa-plus me-2"></i>Create New Task
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body bg-white rounded">
                <form action="{{ route('tasks.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="priority" class="form-label fw-bold text-secondary">
                                <i class="fas fa-flag me-2"></i>Priority Filter
                            </label>
                            <select name="priority" id="priority" class="form-select form-select-lg">
                                <option value="">All Priorities</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High Priority</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium Priority</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low Priority</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="sort" class="form-label fw-bold text-secondary">
                                <i class="fas fa-sort me-2"></i>Sort By Due Date
                            </label>
                            <select name="sort" id="sort" class="form-select form-select-lg">
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Earliest First</option>
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Latest First</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-dark btn-lg w-100">
                                <i class="fas fa-filter me-2"></i>Apply Filters
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tasks Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Due Date</th>
                                <th class="px-4 py-3">Priority</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tasks as $task)
                            <tr>
                                <td class="px-4">
                                    <h5 class="mb-1">{{ $task->title }}</h5>
                                    <p class="text-muted small mb-0">{{ Str::limit($task->description, 50) }}</p>
                                </td>
                                <td class="px-4">
                                    <span class="badge bg-light text-dark border">
                                        <i class="far fa-calendar me-1"></i>
                                        {{ $task->due_date->format('M d, Y') }}
                                    </span>
                                </td>
                                <td class="px-4">
                                    @php
                                        $priorityColors = [
                                            'high' => 'danger',
                                            'medium' => 'warning',
                                            'low' => 'success'
                                        ];
                                        $priorityIcons = [
                                            'high' => 'exclamation-circle',
                                            'medium' => 'exclamation',
                                            'low' => 'check-circle'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $priorityColors[$task->priority] }}-subtle text-{{ $priorityColors[$task->priority] }} border border-{{ $priorityColors[$task->priority] }}">
                                        <i class="fas fa-{{ $priorityIcons[$task->priority] }} me-1"></i>
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </td>
                                <td class="px-4">
                                    <div class="d-flex gap-2">
                                        <span class="badge {{ $task->is_completed ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border border-secondary' }}">
                                            <i class="fas fa-{{ $task->is_completed ? 'check' : 'clock' }} me-1"></i>
                                            {{ $task->is_completed ? 'Completed' : 'Pending' }}
                                        </span>
                                        <span class="badge {{ $task->is_paid ? 'bg-success-subtle text-success border border-success' : 'bg-warning-subtle text-warning border border-warning' }}">
                                            <i class="fas fa-{{ $task->is_paid ? 'check-circle' : 'exclamation-circle' }} me-1"></i>
                                            {{ $task->is_paid ? 'Paid' : 'Not Paid' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4">
                                    <div class="btn-group">
                                        @if(!$task->is_completed)
                                        <form action="{{ route('tasks.complete', $task->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Mark Complete">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        @endif

                                        @if(!$task->is_paid)
                                        <a href="{{ route('tasks.pay', $task->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Process Payment">
                                            <i class="fas fa-credit-card"></i>
                                        </a>
                                        @endif

                                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Edit Task">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')" data-bs-toggle="tooltip" title="Delete Task">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center p-5">
                                    <div class="text-muted">
                                        <i class="fas fa-tasks fa-3x mb-3"></i>
                                        <h4>No tasks found</h4>
                                        <p>Get started by creating your first task!</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $tasks->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection