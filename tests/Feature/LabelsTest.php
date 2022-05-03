<?php

namespace Geeksesi\TodoLover\Tests;

use Geeksesi\TodoLover\Models\Label;
use Geeksesi\TodoLover\Models\Task;
use Geeksesi\TodoLover\Tests\TestCase;
use Illuminate\Support\Facades\Cache;

class LabelsTest extends TestCase
{
    public function test_labels_list()
    {
        $owner = $this->authentication();
        factory(Label::class, 25)->create();
        $res = $this->get("api/todo_lover/labels");
        $res->assertSuccessful();
        // $res->dump();
        $res->assertJsonStructure(["data" => [["id", "title"]]]);
    }

    public function test_label_tasks_count()
    {
        Cache::flush();
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
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
            factory(Task::class)->make(),
        ];
        $owner->tasks()->saveMany($tasks);

        Label::insert([["title" => "sprint1"], ["title" => "sprint2"], ["title" => "sprint3"], ["title" => "bug"]]);

        $counts = [];
        foreach ($tasks as $task) {
            $labels = Label::all()
                ->random(3)
                ->toArray();
            $ids = array_column($labels, "id");
            foreach ($ids as $id) {
                $counts[$id] = ($counts[$id] ?? 0) + 1;
            }
            $task->labels()->sync($ids);
        }

        $res = $this->get("api/todo_lover/labels");
        $res->assertSuccessful();
        $res->dump();
        $res->assertJsonStructure(["data" => [["id", "title", "count"]]]);

        foreach (json_decode($res->getContent(), true)["data"] as $label) {
            $this->assertEquals($label["count"], $counts[$label["id"]]);
        }
    }
}
