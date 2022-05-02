<?php

namespace Geeksesi\TodoLover\Http\Controllers;

use Geeksesi\TodoLover\Http\Requests\Label\IndexRequest;
use Geeksesi\TodoLover\Http\Resources\LabelResource;
use Geeksesi\TodoLover\Models\Label;

class LabelController extends Controller
{
    public function index(IndexRequest $request)
    {
        $labels = Label::simplePaginate();
        return LabelResource::collection($labels);
    }
}
