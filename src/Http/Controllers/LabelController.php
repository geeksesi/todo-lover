<?php

namespace Geeksesi\TodoLover\Http\Controllers;

use Geeksesi\TodoLover\Http\Requests\Label\IndexRequest;
use Geeksesi\TodoLover\Http\Resources\LabelCollection;
use Geeksesi\TodoLover\Models\Label;

class LabelController extends Controller
{
    public function index(IndexRequest $request): LabelCollection
    {
        $labels = Label::simplePaginate();
        return new LabelCollection($labels);
    }
}
