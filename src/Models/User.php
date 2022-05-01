<?php

namespace Geeksesi\TodoLover\Models;

use Geeksesi\TodoLover\HasTaskTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasTaskTrait;
}
