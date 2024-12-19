<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\DeleteOldCompletedTasks;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('tasks:delete-old', function () {
    DeleteOldCompletedTasks::dispatch();
    $this->info('Job de limpeza de tarefas antigas foi disparado!');
})->purpose('Deleta tarefas concluídas há mais de 7 dias');
