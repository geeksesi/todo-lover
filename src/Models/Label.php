<?php

namespace Geeksesi\TodoLover\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Label extends Model
{
    protected $fillable = ["title"];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, "label_task");
    }

    public static function countCacheKey(int $owner_id, int $label_id): string
    {
        return "label_count_" . $owner_id . "_" . $label_id;
    }

    public function tasksCount(\OwnerModel $owner): int
    {
        $key = Label::countCacheKey($owner->id, $this->id);
        if (Cache::has($key)) {
            return Cache::get($key);
        }
        $count = $this->tasks()
            ->owned($owner)
            ->count();
        Cache::put($key, $count);
        return $count;
    }
}
