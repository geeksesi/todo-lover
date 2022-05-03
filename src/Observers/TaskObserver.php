<?php

namespace Geeksesi\TodoLover\Observers;

use Geeksesi\TodoLover\Models\Task;
use Geeksesi\TodoLover\Services\TaskService;

class TaskObserver
{
    public $afterCommit = true;
    /**
     * Handle the Task "created" event.
     *
     * @param  \Geeksesi\TodoLover\Models\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
    }

    /**
     * Handle the Task "updated" event.
     *
     * @param  \Geeksesi\TodoLover\Models\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        (new TaskService())->notifOnStatusChange($task);
    }

    /**
     * Handle the Task "deleted" event.
     *
     * @param  \Geeksesi\TodoLover\Models\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
    }

    /**
     * Handle the Task "restored" event.
     *
     * @param  \Geeksesi\TodoLover\Models\Task  $task
     * @return void
     */
    public function restored(Task $task)
    {
    }

    /**
     * Handle the Task "force deleted" event.
     *
     * @param  \Geeksesi\TodoLover\Models\Task  $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
    }
}
