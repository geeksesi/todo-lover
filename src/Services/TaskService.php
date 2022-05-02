<?php

namespace Geeksesi\TodoLover\Services;

use Geeksesi\TodoLover\Models\Label;
use Geeksesi\TodoLover\Models\Task;
use Geeksesi\TodoLover\Models\User;
use Geeksesi\TodoLover\TaskStatusEnum;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function create(array $data, \OwnerModel $owner): Task
    {
        $task = new Task();
        $task->title = $data["title"];
        $task->description = $data["description"];
        $task->status = TaskStatusEnum::OPEN;

        $owner->tasks()->save($task);

        if (!empty($data["labels"])) {
            $this->handleLabels($task, $data["labels"]);
        }
        return $task;
    }

    public function update(Task $task, array $data): Task
    {
        if (!empty($data["labels"])) {
            $this->handleLabels($task, $data["labels"]);
            unset($data["labels"]);
        }
        $task->update($data);

        return $task;
    }

    private function handleLabels(Task $task, array $labels)
    {
        $labels = array_unique($labels);
        $ids = (new LabelService())->findOrCreateMany($labels);
        return $task->labels()->sync($ids);
    }
}
