<?php

namespace Geeksesi\TodoLover\Services;

use Geeksesi\TodoLover\Mail\TaskStatusUpdateNotification;
use Geeksesi\TodoLover\Models\Task;
use Geeksesi\TodoLover\TaskStatusEnum;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function dispatchTaskStatusNotify(Task $task)
    {
        Mail::to($task->owner->email ?? null)->send(new TaskStatusUpdateNotification($task));

        $this->log($task);
    }

    private function log(Task $task)
    {
        $message =
            "Status of Task: " . $task->title . " was updated to: " . TaskStatusEnum::toString($task->status) . "\n";
        $message = $task->updated_at;
        Log::alert($message);
    }
}
