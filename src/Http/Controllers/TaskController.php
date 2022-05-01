<?php

namespace Geeksesi\TodoLover\Http\Controllers;

use Geeksesi\TodoLover\Http\Requests\Task\IndexRequest;
use Geeksesi\TodoLover\Http\Requests\Task\ShowRequest;
use Geeksesi\TodoLover\Http\Requests\Task\StoreRequest;
use Geeksesi\TodoLover\Http\Requests\Task\UpdateRequest;
use Geeksesi\TodoLover\Http\Resources\TaskCollection;
use Geeksesi\TodoLover\Http\Resources\TaskResource;
use Geeksesi\TodoLover\Models\Task;
use Geeksesi\TodoLover\Services\TaskService;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(IndexRequest $request): TaskCollection
    {
        $tasks = Task::simplePaginate();
        return new TaskCollection($tasks);
    }

    public function show(ShowRequest $request, Task $task): TaskResource
    {
        return new TaskResource($task);
    }

    public function store(StoreRequest $request): TaskResource
    {
        $data = $request->validated();
        $owner = Auth::user();
        $task = (new TaskService())->create($data, $owner);
        return new TaskResource($task);
    }

    public function update(UpdateRequest $request, Task $task): TaskResource
    {
        $data = $request->validated();
        $task = (new TaskService())->update($task, $data);
        return new TaskResource($task);
    }
}
