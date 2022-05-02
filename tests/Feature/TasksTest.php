<?php

namespace Geeksesi\TodoLover\Tests;

use Geeksesi\TodoLover\Models\Label;
use Geeksesi\TodoLover\Models\Task;
use Geeksesi\TodoLover\Models\User;
use Geeksesi\TodoLover\TaskStatusEnum;
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
            "data" => ["labels", "title", "description", "status"],
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
            "data" => ["labels", "title", "description", "status"],
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

    public function test_update_logedin_user_task()
    {
        $owner = $this->authentication();
        $task = factory(Task::class)->make();
        $owner->tasks()->save($task);

        $res = $this->putJson("api/todo_lover/tasks/" . $task->id, [
            "title" => Str::random(10),
            "description" => Str::random(100),
        ]);
        $res->assertSuccessful();
        // $res->dump();

        $res->assertJsonStructure([
            "data" => ["labels", "title", "description", "status"],
        ]);

        assertEquals(
            $res->original->owner->id,
            $owner->id,
            "owner is not equal test: " . $owner->id . " actual: " . $res->original->owner->id
        );
    }

    public function test_cant_update_others_task()
    {
        $owner = $this->authentication();
        $other_owner = factory(\OwnerModel::class)->create();
        $task = factory(Task::class)->make();
        $other_owner->tasks()->save($task);

        $res = $this->get("api/todo_lover/tasks/" . $task->id, [
            "title" => Str::random(10),
            "description" => Str::random(100),
        ]);
        $res->assertForbidden();
        // $res->dump();
    }

    public function test_update_logedin_user_task_status_to_inprogress()
    {
        $owner = $this->authentication();
        $task = factory(Task::class)->make();
        $owner->tasks()->save($task);

        $res = $this->putJson("api/todo_lover/tasks/" . $task->id, [
            "status" => TaskStatusEnum::INPROGRESS,
        ]);
        $res->assertSuccessful();
        // $res->dump();

        $res->assertJsonStructure([
            "data" => ["labels", "title", "description", "status"],
        ]);
        $this->assertEquals(
            $res->original->status,
            TaskStatusEnum::INPROGRESS,
            "status didn't update"
        );
        $this->assertEquals(
            $res->original->owner->id,
            $owner->id,
            "owner is not equal test: " . $owner->id . " actual: " . $res->original->owner->id
        );
    }

    public function test_update_logedin_user_task_status_to_done()
    {
        $owner = $this->authentication();
        $task = factory(Task::class)->make();
        $owner->tasks()->save($task);

        $res = $this->putJson("api/todo_lover/tasks/" . $task->id, [
            "status" => TaskStatusEnum::DONE,
        ]);
        $res->assertSuccessful();
        // $res->dump();

        $res->assertJsonStructure([
            "data" => ["labels", "title", "description", "status"],
        ]);
        $this->assertEquals($res->original->status, TaskStatusEnum::DONE, "status didn't update");
        $this->assertEquals(
            $res->original->owner->id,
            $owner->id,
            "owner is not equal test: " . $owner->id . " actual: " . $res->original->owner->id
        );
    }

    public function test_list_of_logedin_user_tasks()
    {
        $owner = $this->authentication();
        $owner
            ->tasks()
            ->saveMany([
                factory(Task::class)->make(),
                factory(Task::class)->make(),
                factory(Task::class)->make(),
                factory(Task::class)->make(),
                factory(Task::class)->make(),
                factory(Task::class)->make(),
                factory(Task::class)->make(),
            ]);

        $res = $this->get("api/todo_lover/tasks/");
        $res->assertSuccessful();
        // $res->dump();

        $res->assertJsonStructure([
            "data" => [["labels", "title", "description", "status", "status_string"]],
        ]);
        foreach ($res->original as $response_task) {
            $this->assertEquals(
                $response_task->owner->id,
                $owner->id,
                "owner is not equal test: " . $owner->id . " actual: " . $response_task->owner->id
            );
        }
    }

    public function test_cant_get_list_of_other_user_tasks()
    {
        $owner = $this->authentication();
        $other_owner = factory(\OwnerModel::class)->create();
        $other_owner
            ->tasks()
            ->saveMany([
                factory(Task::class)->make(),
                factory(Task::class)->make(),
                factory(Task::class)->make(),
                factory(Task::class)->make(),
                factory(Task::class)->make(),
                factory(Task::class)->make(),
                factory(Task::class)->make(),
                factory(Task::class)->make(),
            ]);

        $res = $this->get("api/todo_lover/tasks/");
        $res->assertSuccessful();
        $res->dump();
        // should be empty
        $res->assertJson([
            "data" => [],
        ]);
    }
}
