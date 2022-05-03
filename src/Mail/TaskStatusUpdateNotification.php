<?php

namespace Geeksesi\TodoLover\Mail;

use Geeksesi\TodoLover\Models\Task;
use Geeksesi\TodoLover\TaskStatusEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskStatusUpdateNotification extends Mailable
{
    use Queueable, SerializesModels;

    private Task $task;

    /**
     * Create a new task instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env("MAIL_FROM_ADDRESS", "info@test.com"), env("MAIL_FROM_NAME", "info"))
            ->subject("Task #" . $this->task->id . " updated")
            ->html("new task status: " . TaskStatusEnum::toString($this->task->status));
    }
}
