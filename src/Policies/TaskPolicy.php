<?php

namespace Geeksesi\TodoLover\Policies;

use Geeksesi\TodoLover\Models\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the \OwnerModel can view any models.
     *
     * @param  \App\Models\\OwnerModel\\OwnerModel  $owner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(\OwnerModel $owner)
    {
        return false;
    }

    /**
     * Determine whether the \OwnerModel can view the model.
     *
     * @param  \App\Models\\OwnerModel\\OwnerModel  $owner
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(\OwnerModel $owner, Task $task)
    {
        return $task->owner === $owner;
    }

    /**
     * Determine whether the \OwnerModel can create models.
     *
     * @param  \App\Models\\OwnerModel\\OwnerModel  $owner
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(\OwnerModel $owner)
    {
        return true;
    }

    /**
     * Determine whether the \OwnerModel can update the model.
     *
     * @param  \App\Models\\OwnerModel\\OwnerModel  $owner
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(\OwnerModel $owner, Task $task)
    {
        return $task->owner === $owner;
    }

    /**
     * Determine whether the \OwnerModel can delete the model.
     *
     * @param  \App\Models\\OwnerModel\\OwnerModel  $owner
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(\OwnerModel $owner, Task $task)
    {
        return false;
    }

    /**
     * Determine whether the \OwnerModel can restore the model.
     *
     * @param  \App\Models\\OwnerModel\\OwnerModel  $owner
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(\OwnerModel $owner, Task $task)
    {
        return false;
    }

    /**
     * Determine whether the \OwnerModel can permanently delete the model.
     *
     * @param  \App\Models\\OwnerModel\\OwnerModel  $owner
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(\OwnerModel $owner, Task $task)
    {
        return false;
    }
}
