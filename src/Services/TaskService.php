<?php

namespace Geeksesi\TodoLover\Services;

use Geeksesi\TodoLover\Models\Label;
use Geeksesi\TodoLover\Models\Task;
use Geeksesi\TodoLover\Models\User;
use Geeksesi\TodoLover\TaskStatusEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
            $this->clearLabelTaskCountCach($task);
        }
        return $task;
    }

    public function update(Task $task, array $data): Task
    {
        if (!empty($data["labels"])) {
            $this->handleLabels($task, $data["labels"]);
            unset($data["labels"]);
            $this->clearLabelTaskCountCach($task);
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

    public function clearLabelTaskCountCach(Task $task)
    {
        foreach ($task->labels as $label) {
            $key = Label::countCacheKey($task->owner_id, $label->id);
            Cache::forget($key);
        }
    }

    public function notifOnStatusChange(Task $task)
    {
        if (!$task->wasChanged("status")) {
            return;
        }
        (new NotificationService())->dispatchTaskStatusNotify($task);
    }
}
