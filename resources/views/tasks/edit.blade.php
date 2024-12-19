@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Editar Tarefa</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('tasks._form', ['task' => $task, 'categories' => $categories, 'buttonText' => 'Atualizar Tarefa'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
