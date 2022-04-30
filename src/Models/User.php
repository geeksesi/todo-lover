<?php

namespace Geeksesi\TodoLover\Models;

use Geeksesi\TodoLover\HasTaskTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasTaskTrait;
    use HasFactory;
}
