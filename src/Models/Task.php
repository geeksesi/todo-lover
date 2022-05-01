<?php

namespace Geeksesi\TodoLover\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = ["title", "description", "status"];

    public function lables()
    {
        return $this->hasManyThrough(Lable::class, "task_lable");
    }

    public function owner()
    {
        return $this->morphTo();
    }
}
