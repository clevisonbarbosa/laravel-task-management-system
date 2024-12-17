@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Tarefa</h1>

        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')
            @include('tasks._form', ['task' => $task, 'categories' => $categories, 'buttonText' => 'Atualizar Tarefa'])
        </form>
    </div>
@endsection
