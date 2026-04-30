<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use OpenApi\Annotations as OA;
abstract class Controller
{
    //
    use AuthorizesRequests;
}
