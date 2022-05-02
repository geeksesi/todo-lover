<?php

namespace Geeksesi\TodoLover\Services;

use Geeksesi\TodoLover\Models\Task;
use Geeksesi\TodoLover\Models\User;
use Geeksesi\TodoLover\TaskStatusEnum;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function create(array $data, \OwnerModel $owner): Task
    {
        if (!empty($data["labels"])) {
            $labels = $this->handleLabels($data["labels"]);
        }
        $task = new Task();
        $task->title = $data["title"];
        $task->description = $data["description"];
        $task->status = TaskStatusEnum::OPEN;

        $owner->tasks()->save($task);
        return $task;
    }

    public function update(Task $task, array $data): Task
    {
        if (!empty($data["labels"])) {
            $labels = $this->handleLabels($data["labels"]);
            unset($data["labels"]);
        }
        $task->update($data);

        return $task;
    }

    private function handleLabels(array $labels): array
    {
        return [];
    }
}
