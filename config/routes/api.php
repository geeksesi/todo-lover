<?php

use Geeksesi\TodoLover\Http\Controllers\LabelController;
use Geeksesi\TodoLover\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::apiResource("tasks", TaskController::class)->except("destroy");
Route::apiResource("labels", LabelController::class)->only("index");