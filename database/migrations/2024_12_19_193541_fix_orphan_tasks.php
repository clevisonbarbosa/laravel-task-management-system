<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixOrphanTasks extends Migration
{
    public function up(): void
    {
        $firstUserId = DB::table('users')->value('id');

        if (!$firstUserId) {
            return;
        }

        $orphanTasks = DB::table('tasks')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('task_user')
                    ->whereRaw('task_user.task_id = tasks.id');
            })
            ->get();

        foreach($orphanTasks as $task) {
            DB::table('task_user')->insert([
                'task_id' => $task->id,
                'user_id' => $firstUserId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
    }
}
