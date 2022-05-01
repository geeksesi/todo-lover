<?php

namespace Geeksesi\TodoLover\Tests;

use Geeksesi\TodoLover\Models\Label;
use Geeksesi\TodoLover\Models\Task;

class TasksTest extends TestCase {
    
    public function test_create_task()
    {
        $owner = $this->authentication();

        $lable = factory(Label::class)->create();
        $task_mock = factory(Task::class);
        
        $res = $this->postJson(route('todo_lover.task.create'), [
            "label"=> $lable->id,
            "title"=> $task_mock->title,
            "description"=> $task_mock->description,
        ]);
        $res->assertSuccessful();
        $res->assertJsonStructure([
            "data"=> ["lable", "title", "description", "owner"]
        ]);
        $res->assertJson([]);
    }
}