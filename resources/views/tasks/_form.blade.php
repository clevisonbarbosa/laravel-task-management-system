<div class="mb-3">
    <label for="title" class="form-label">Título da Tarefa</label>
    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $task->title ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descrição</label>
    <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $task->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="category_id" class="form-label">Categoria</label>
    <select name="category_id" id="category_id" class="form-control">
        <option value="">Sem Categoria</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $task->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="new_category" class="form-label">Criar Nova Categoria</label>
    <input type="text" name="new_category" id="new_category" class="form-control" placeholder="Digite o nome da nova categoria">
</div>

<div class="mb-3">
    <label for="users" class="form-label">Atribuir Usuários</label>
    <select name="users[]" id="users" class="form-control" multiple>
        @foreach ($allUsers as $user)
            <option value="{{ $user->id }}"
                {{ isset($task) && $task->users->contains($user) ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="is_completed" id="is_completed" class="form-check-input" {{ old('is_completed', $task->is_completed ?? false) ? 'checked' : '' }}>
    <label for="is_completed" class="form-check-label">Marcar como concluída</label>
</div>

<div class="d-flex justify-content-between">
    <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancelar</a>
</div>
