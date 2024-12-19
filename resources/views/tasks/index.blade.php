@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Suas Tarefas</h5>
                        <a href="{{ route('tasks.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Criar Tarefa
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('tasks.index') }}" class="mb-4 bg-light p-3 rounded">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label for="category_id" class="form-label">Categoria</label>
                                <select name="category_id" id="category_id" class="form-select">
                                    <option value="">Todas as Categorias</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-5">
                                <label for="is_completed" class="form-label">Status</label>
                                <select name="is_completed" id="is_completed" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="1" {{ request('is_completed') === '1' ? 'selected' : '' }}>Concluídas</option>
                                    <option value="0" {{ request('is_completed') === '0' ? 'selected' : '' }}>Pendentes</option>
                                </select>
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        @if ($tasks->isEmpty())
                        <div class="alert alert-info">
                            Nenhuma tarefa encontrada com os filtros selecionados.
                        </div>
                        @else
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Título</th>
                                    <th>Descrição</th>
                                    <th>Categoria</th>
                                    <th>Usuários</th>
                                    <th>Status</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ Str::limit($task->description, 50) }}</td>
                                    <td>{{ $task->category->name ?? 'Sem Categoria' }}</td>
                                    <td>
                                        @foreach($task->users as $user)
                                        <span class="badge bg-info me-1" title="{{ $user->email }}">
                                            {{ Str::limit($user->name, 20) }}
                                        </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <span class="badge {{ $task->is_completed ? 'bg-success' : 'bg-warning' }}">
                                            {{ $task->is_completed ? 'Concluída' : 'Pendente' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirmDeletion()">
                                                    <i class="fas fa-trash"></i> Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDeletion() {
        return confirm("Tem certeza de que deseja remover esta tarefa?");
    }
</script>
@endsection

<style>
    .table td {
        vertical-align: middle;
    }

    .table td.text-center {
        min-width: 200px;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .d-flex.gap-2 {
        display: flex !important;
        gap: 0.5rem !important;
    }

    form.m-0 {
        margin: 0 !important;
    }
</style>
