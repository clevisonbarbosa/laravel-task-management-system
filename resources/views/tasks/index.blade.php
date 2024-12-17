@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('Your Tasks') }}</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">{{ __('Create Task') }}</a>

        @if ($tasks->isEmpty())
            <p>{{ __('No tasks found.') }}</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">{{ __('Title') }}</th>
                        <th scope="col">{{ __('Description') }}</th>
                        <th scope="col">{{ __('Category') }}</th>
                        <th scope="col">{{ __('Status') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->category->name ?? __('Uncategorized') }}</td>
                            <td>{{ $task->is_completed ? __('Completed') : __('Pending') }}</td>
                            <td>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">{{ __('Edit') }}</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline" onsubmit="return confirmDeletion()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                            </form>

                            <script>
                                function confirmDeletion() {
                                    return confirm("Tem certeza de que deseja remover esta task?");
                                }
                            </script>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
