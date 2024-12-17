@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Criar Tarefa</h1>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            @include('tasks._form', ['task' => null, 'categories' => $categories, 'buttonText' => 'Criar Tarefa'])
        </form>
    </div>
@endsection
