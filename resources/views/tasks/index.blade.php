@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Your Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Create Task</a>

        @if ($tasks->isEmpty())
            <p>No tasks found.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->category->name ?? 'Uncategorized' }}</td>
                            <td>{{ $task->is_completed ? 'Completed' : 'Pending' }}</td>
                            <td>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
