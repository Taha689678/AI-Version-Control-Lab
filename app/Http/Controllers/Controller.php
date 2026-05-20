<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * The Base Controller.
 * All other controllers extend this class.
 * We include AuthorizesRequests to allow usage of Policies (e.g., $this->authorize)
 * and ValidatesRequests for older style validation if needed.
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}