<?php

use Geeksesi\TodoLover\Http\Middleware\UserHandMadeTokenAuthorize;

return [
    /*
    |--------------------------------------------------------------------------
    | TodoLover Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be assigned to every TodoLover route, giving you
    | the chance to add your own middleware to this list or change any of
    | the existing middleware. Or, you can simply stick with this list.
    |
    */

    "middleware" => ["api", UserHandMadeTokenAuthorize::class],
];
