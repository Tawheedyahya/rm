<?php

namespace App\Http\Controllers;

use App\Services\Pqueueservice;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
#[Group('QUEUE')]
class Pqueuecontroller extends Controller
{
    //
    private $pqueue_service;
    public function construct(){
        $this->pqueue_service=new Pqueueservice();
    }
    public function create(){
        
    }
}
