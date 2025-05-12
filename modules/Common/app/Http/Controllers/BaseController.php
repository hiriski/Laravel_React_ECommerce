<?php

namespace Modules\Common\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as RoutingController;

class BaseController extends RoutingController
{
    use AuthorizesRequests, ValidatesRequests;
}
