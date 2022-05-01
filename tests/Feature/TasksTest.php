<?php

namespace Geeksesi\TodoLover\Tests;

use Geeksesi\TodoLover\Models\Label;
use Geeksesi\TodoLover\Models\Task;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;

class TasksTest extends TestCase
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
        $res->dump();

        $res->assertJsonStructure([
            "data" => ["labels", "title", "description"],
        ]);
    }
}
