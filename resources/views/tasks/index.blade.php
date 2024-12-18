@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Suas Tarefas</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Criar Tarefa</a>

        <!-- Formulário de Filtros -->
        <form method="GET" action="{{ route('tasks.index') }}" class="mb-4">
            <div class="row">
                <!-- Filtro por Categoria -->
                <div class="col-md-4">
                    <label for="category_id" class="form-label">Filtrar por Categoria</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">Todas as Categorias</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro por Status -->
                <div class="col-md-4">
                    <label for="is_completed" class="form-label">Filtrar por Status</label>
                    <select name="is_completed" id="is_completed" class="form-control">
                        <option value="">Todos</option>
                        <option value="1" {{ request('is_completed') == '1' ? 'selected' : '' }}>Concluídas</option>
                        <option value="0" {{ request('is_completed') == '0' ? 'selected' : '' }}>Pendentes</option>
                    </select>
                </div>

                <!-- Botão de Filtrar -->
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </div>
        </form>

        @if ($tasks->isEmpty())
            <p>Nenhuma tarefa encontrada.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Título</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->category->name ?? 'Sem Categoria' }}</td>
                            <td>{{ $task->is_completed ? 'Concluída' : 'Pendente' }}</td>
                            <td>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline" onsubmit="return confirmDeletion()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                </form>

                                <script>
                                    function confirmDeletion() {
                                        return confirm("Tem certeza de que deseja remover esta tarefa?");
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
