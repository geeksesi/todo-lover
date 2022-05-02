<?php

namespace Geeksesi\TodoLover\Tests\Task;

use Geeksesi\TodoLover\Tests\TestCase;
use Illuminate\Support\Str;

class TasksCreateTest extends TestCase
{
    public function test_create_task()
    {
        $owner = $this->authentication();

        $res = $this->postJson("api/todo_lover/tasks", [
            // "label" => ["سلام"],
            "title" => Str::random(10),
            "description" => Str::random(100),
        ]);
        $res->assertSuccessful();
        // $res->dump();

        $res->assertJsonStructure([
            "data" => ["labels", "title", "description", "status"],
        ]);
    }
}
