<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Laravel\Octane\Facades\Octane;

class Practisecontroller extends Controller
{
    //
    public function index(){
    $results = Octane::concurrently([
        fn () => Hotel::where('city', 'New York')->get(),
        fn () => Hotel::where('state', 'California')->get(),
    ]);

    return response()->json([
        'new_york' => $results[0],
        'california' => $results[1],
    ]);
    }
}
