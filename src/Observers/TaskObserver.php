<?php

namespace Geeksesi\TodoLover\Observers;

use Geeksesi\TodoLover\Models\Task;

class TaskObserver
{
    public $afterCommit = true;
    /**
     * Handle the Task "created" event.
     *
     * @param  \App\Models\Task\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
    }

    /**
     * Handle the Task "updated" event.
     *
     * @param  \App\Models\Task\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        //
    }

    /**
     * Handle the Task "deleted" event.
     *
     * @param  \App\Models\Task\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     *
     * @param  \App\Models\Task\Task  $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     *
     * @param  \App\Models\Task\Task  $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
}
