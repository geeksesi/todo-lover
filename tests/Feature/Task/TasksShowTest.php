<?php

namespace Geeksesi\TodoLover\Tests\Task;

use Geeksesi\TodoLover\Models\Label;
use Geeksesi\TodoLover\Models\Task;
use Geeksesi\TodoLover\Tests\TestCase;
use Illuminate\Support\Arr;

use function PHPUnit\Framework\assertEquals;

class TasksShowTest extends TestCase
{
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
        // $res->dump();
        // should be empty
        $res->assertJson([
            "data" => [],
        ]);
    }

    public function test_task_list_by_label()
    {
        $owner = $this->authentication();
        $tasks = [
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
        ];
        $owner->tasks()->saveMany($tasks);

        Label::insert([["title" => "sprint1"], ["title" => "sprint2"], ["title" => "bug"]]);

        $random_label = Label::all()->random();
        foreach ($tasks as $task) {
            $task->labels()->sync([Label::all()->random()->id]);
        }

        $res = $this->get("api/todo_lover/tasks?label=" . $random_label->id);
        $res->assertSuccessful();
        // $res->dump();

        foreach ($res->original as $task) {
            $this->assertEquals($task->labels[0]->id, $random_label->id);
        }
    }

    public function test_task_list_by_label_when_task_has_multiple_label()
    {
        $owner = $this->authentication();
        $tasks = [
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
        ];
        $owner->tasks()->saveMany($tasks);

        Label::insert([
            ["title" => "sprint1"],
            ["title" => "sprint2"],
            ["title" => "sprint3"],
            ["title" => "sprint4"],
            ["title" => "bug"],
        ]);

        $random_label = Label::all()->random();
        foreach ($tasks as $task) {
            $labels = Label::all()
                ->random(3)
                ->toArray();
            $ids = array_column($labels, "id");
            $task->labels()->sync($ids);
        }

        $res = $this->get("api/todo_lover/tasks?label=" . $random_label->id);
        $res->assertSuccessful();
        // $res->dump();

        foreach ($res->original as $task) {
            $has_label = false;
            foreach ($task->labels as $label) {
                if ($label->id === $random_label->id) {
                    $has_label = true;
                }
            }
            $this->assertTrue($has_label);
        }
    }
}
