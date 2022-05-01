<?php

namespace Geeksesi\TodoLover;

use Geeksesi\TodoLover\Models\Task;

trait HasTaskTrait
{
    public function tasks()
    {
        return $this->morphMany(Task::class, "owner");
    }
}
