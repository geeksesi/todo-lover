<?php

namespace Geeksesi\TodoLover\Services;

use Geeksesi\TodoLover\Models\Label;
use Illuminate\Support\Facades\DB;

class LabelService
{
    public function findOrCreateMany(array $titles): array
    {
        if (!$this->insertMany($titles)) {
            return false;
        }
        $labels = Label::whereIn("title", $titles)
            ->get()
            ->toArray();
        $ids = array_column($labels, "id");
        return $ids;
    }

    public function insertMany(array $titles): bool
    {
        $should_create = [];
        foreach ($titles as $title) {
            $should_create[] = ["title" => $title];
        }
        if (!empty($should_create)) {
            if (Label::insertOrIgnore($should_create) === false) {
                return false;
            }
        }
        return true;
    }
}
