<div class="mb-3">
    <label for="title" class="form-label">Título da Tarefa</label>
    <input type="text" name="title" id="title"
        class="form-control @error('title') is-invalid @enderror"
        value="{{ old('title', $task->title ?? '') }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descrição</label>
    <textarea name="description" id="description"
        class="form-control @error('description') is-invalid @enderror"
        rows="4">{{ old('description', $task->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="category_id" class="form-label">Categoria</label>
    <select name="category_id" id="category_id"
        class="form-control @error('category_id') is-invalid @enderror">
        <option value="">Sem Categoria</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                {{ old('category_id', $task->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="new_category" class="form-label">Criar Nova Categoria</label>
    <input type="text" name="new_category" id="new_category"
        class="form-control @error('new_category') is-invalid @enderror"
        placeholder="Digite o nome da nova categoria"
        value="{{ old('new_category') }}">
    @error('new_category')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="users" class="form-label">Atribuir Usuários</label>
    <select name="users[]" id="users"
        class="form-control @error('users') is-invalid @enderror" multiple>
        @foreach ($allUsers as $user)
            <option value="{{ $user->id }}"
                {{ (isset($task) && $task->users->contains($user)) ||
                   (old('users') && in_array($user->id, old('users', []))) ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    @error('users')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="is_completed" id="is_completed"
        class="form-check-input @error('is_completed') is-invalid @enderror"
        {{ old('is_completed', $task->is_completed ?? false) ? 'checked' : '' }}>
    <label for="is_completed" class="form-check-label">Marcar como concluída</label>
    @error('is_completed')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex justify-content-between mt-4 pt-3 border-top">
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> {{ $buttonText }}
    </button>
</div>
