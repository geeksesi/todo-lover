<?php

namespace Geeksesi\TodoLover\Tests;

use Geeksesi\TodoLover\Models\Label;
use Geeksesi\TodoLover\Models\Task;
use Geeksesi\TodoLover\Models\User;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;

use function PHPUnit\Framework\assertEquals;

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
        // $res->dump();

        $res->assertJsonStructure([
            "data" => ["labels", "title", "description"],
        ]);
    }

    public function test_show_logedin_user_task()
    {
        $owner = $this->authentication();
        $task = factory(Task::class)->make();
        $owner->tasks()->save($task);

        $res = $this->get("api/todo_lover/tasks/" . $task->id);
        $res->assertSuccessful();
        // $res->dump();

        $res->assertJsonStructure([
            "data" => ["labels", "title", "description"],
        ]);

        assertEquals(
            $res->original->owner->id,
            $owner->id,
            "owner is not equal test: " . $owner->id . " actual: " . $res->original->owner->id
        );
    }

    public function test_cant_show_others_task()
    {
        $owner = $this->authentication();
        $other_owner = factory(\OwnerModel::class)->create();
        $task = factory(Task::class)->make();
        $other_owner->tasks()->save($task);

        $res = $this->get("api/todo_lover/tasks/" . $task->id);
        $res->assertForbidden();
        // $res->dump();
    }
}
