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
            "title" => Str::random(10),
            "description" => Str::random(100),
        ]);
        $res->assertSuccessful();
        // $res->dump();

        $res->assertJsonStructure([
            "data" => ["labels", "title", "description", "status"],
        ]);
    }

    public function test_create_with_label_task()
    {
        $owner = $this->authentication();

        $res = $this->postJson("api/todo_lover/tasks", [
            "labels" => ["hello", "bye"],
            "title" => Str::random(10),
            "description" => Str::random(100),
        ]);
        $res->assertSuccessful();
        // $res->dump();

        $res->assertJsonStructure([
            "data" => ["labels" => [["id", "title", "count"]], "title", "description", "status"],
        ]);
    }

    public function test_create_with_duplicate_label_task()
    {
        $owner = $this->authentication();

        $res = $this->postJson("api/todo_lover/tasks", [
            "labels" => ["hello", "hello"],
            "title" => Str::random(10),
            "description" => Str::random(100),
        ]);
        $res->assertSuccessful();
        // $res->dump();

        $res->assertJsonStructure([
            "data" => ["labels" => [["id", "title", "count"]], "title", "description", "status"],
        ]);
    }
    public function test_create_with_duplicate_label_for_seprate_task()
    {
        $owner = $this->authentication();

        $res = $this->postJson("api/todo_lover/tasks", [
            "labels" => ["hello"],
            "title" => Str::random(10),
            "description" => Str::random(100),
        ]);
        $res->assertSuccessful();
        // $res->dump();
        $res->assertJsonStructure([
            "data" => ["labels" => [["id", "title", "count"]], "title", "description", "status"],
        ]);

        $res2 = $this->postJson("api/todo_lover/tasks", [
            "labels" => ["hello", "bye"],
            "title" => Str::random(10),
            "description" => Str::random(100),
        ]);
        $res2->assertSuccessful();
        // $res2->dump();

        $res2->assertJsonStructure([
            "data" => ["labels" => [["id", "title", "count"]], "title", "description", "status"],
        ]);
    }
}
