<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider; // Use o Provider correto
use App\Models\Task;
use App\Policies\TaskPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * O mapeamento de Policies para Models.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Task::class => TaskPolicy::class,
    ];

    /**
     * Bootstrap serviços de autenticação/autorização.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
