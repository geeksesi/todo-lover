<?php

namespace Geeksesi\TodoLover\Tests\Task;

use Geeksesi\TodoLover\Mail\TaskStatusUpdateNotification;
use Geeksesi\TodoLover\Models\Label;
use Geeksesi\TodoLover\Models\Task;
use Geeksesi\TodoLover\TaskStatusEnum;
use Geeksesi\TodoLover\Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TasksUpdateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
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

        $this->assertEquals(
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
        $this->assertEquals($res->original->status, TaskStatusEnum::INPROGRESS, "status didn't update");
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

    public function test_send_main_on_update_task_status()
    {
        $owner = $this->authentication();
        $task = factory(Task::class)->make();
        $owner->tasks()->save($task);

        $res = $this->putJson("api/todo_lover/tasks/" . $task->id, [
            "status" => TaskStatusEnum::DONE,
        ]);
        $res->assertSuccessful();
        // $res->dump();

        Mail::assertSent(TaskStatusUpdateNotification::class);

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

    public function test_update_task_label()
    {
        $owner = $this->authentication();
        $task = factory(Task::class)->make();
        $owner->tasks()->save($task);
        $task->labels()->save(new Label(["title" => "hello"]));

        $res = $this->putJson("api/todo_lover/tasks/" . $task->id, [
            "title" => Str::random(10),
            "description" => Str::random(100),
            "labels" => ["bye"],
        ]);
        $res->assertSuccessful();
        // $res->dump();

        $res->assertJsonStructure([
            "data" => ["labels", "title", "description", "status"],
        ]);

        $this->assertEquals($res->original->labels[0]->title, "bye");

        $this->assertEquals(
            $res->original->owner->id,
            $owner->id,
            "owner is not equal test: " . $owner->id . " actual: " . $res->original->owner->id
        );
    }

    public function test_just_update_task_label()
    {
        $owner = $this->authentication();
        $task = factory(Task::class)->make();
        $owner->tasks()->save($task);
        $task->labels()->save(new Label(["title" => "hello"]));

        $res = $this->putJson("api/todo_lover/tasks/" . $task->id, [
            "labels" => ["bye", "holo"],
        ]);
        $res->assertSuccessful();
        // $res->dump();

        $res->assertJsonStructure([
            "data" => ["labels", "title", "description", "status"],
        ]);

        $this->assertEquals($res->original->labels[0]->title, "bye");
        // others shouldn't change
        $this->assertEquals($res->original->title, $task->title);
        $this->assertEquals($res->original->description, $task->description);
        $this->assertEquals($res->original->status, $task->status);

        $this->assertEquals(
            $res->original->owner->id,
            $owner->id,
            "owner is not equal test: " . $owner->id . " actual: " . $res->original->owner->id
        );
    }
}
