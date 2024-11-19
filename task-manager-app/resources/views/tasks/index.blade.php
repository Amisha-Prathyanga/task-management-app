@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Task Management</h1>

        <a href="{{ route('tasks.export') }}" class="btn btn-success">
            <i class="fas fa-download"></i> Export to CSV
        </a>

        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Task
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('tasks.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="priority" class="form-label">Priority Filter</label>
                    <select name="priority" id="priority" class="form-select">
                        <option value="">All Priorities</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-secondary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tasks Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Due Date</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                        <tr>
                            <td>
                                <div>{{ $task->title }}</div>
                                <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                            </td>
                            <td>{{ $task->due_date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge {{ $task->priority === 'high' ? 'bg-danger' : ($task->priority === 'medium' ? 'bg-warning' : 'bg-success') }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $task->is_completed ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $task->is_completed ? 'Completed' : 'Pending' }}
                                </span>

                                @if(!$task->is_paid)
                                    <span class="badge bg-warning">Not Paid</span>
                                @else
                                    <span class="badge bg-success">Paid</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if(!$task->is_completed)
                                    <form action="{{ route('tasks.complete', $task->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif

                                    @if(!$task->is_paid)
                                    <a href="{{ route('tasks.pay', $task->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-credit-card"></i> Pay $10
                                    </a>
                                    @endif
                                    
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>


                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No tasks found. Create your first task!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class=" mt-4 d-flex justify-content-center">
            <div> {!! $tasks->links() !!} </div>
    </div>

</div>
@endsection