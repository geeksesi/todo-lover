<?php

namespace Geeksesi\TodoLover\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{

    protected $fillable = ["title"];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, "lable_task");
    }
}
