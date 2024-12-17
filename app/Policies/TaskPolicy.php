<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determina se o usuário pode ver qualquer tarefa.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determina se o usuário pode visualizar uma tarefa específica.
     */
    public function view(User $user, Task $task): bool
    {
        return $task->users->contains($user);
    }

    /**
     * Determina se o usuário pode criar uma tarefa.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determina se o usuário pode atualizar uma tarefa.
     */
    public function update(User $user, Task $task): bool
    {
        return $task->users->contains($user);
    }

    /**
     * Determina se o usuário pode excluir uma tarefa.
     */
    public function delete(User $user, Task $task): bool
    {
        return $task->users->contains($user);
    }
}
