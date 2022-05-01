<?php

namespace Geeksesi\TodoLover\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as ControllersController;

class Controller extends ControllersController
{
    use AuthorizesRequests;
    use DispatchesJobs; 
    use ValidatesRequests;
}
