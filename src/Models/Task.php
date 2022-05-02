<?php

namespace Geeksesi\TodoLover\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ["title", "description", "status"];

    public function labels()
    {
        return $this->belongsToMany(Label::class, "label_task");
    }

    public function owner()
    {
        return $this->morphTo();
    }

    public function scopeOwned($query, \OwnerModel $owner)
    {
        return $query->whereHasMorph("owner", [\OwnerModel::class], function ($q) use ($owner) {
            $q->where("owner_id", $owner->id);
        });
    }

    public function scopeLabelFilter($query, int $label_id)
    {
        if ($label_id === 0) {
            return $query;
        }
        return $query->whereHas("labels", function ($q) use ($label_id) {
            $q->where("label_id", $label_id);
        });
    }
}
