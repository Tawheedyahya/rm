<?php

namespace App\Http\Controllers;

use App\DTOs\Hoteladmin\RegisterDTO;
use App\Http\Requests\Staffrequest;
use App\Services\Staffservice;
use Illuminate\Http\Request;
use Throwable;

class Staffcontroller extends Controller
{
    protected $staffservice;
    public function __construct(Staffservice $staffservice)
    {
        $this->staffservice=$staffservice;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try{
            $data=$this->staffservice->index();
            $status=fstatus($data);
            return response()->json($data,$status);
        }catch(Throwable $e){
            return response()->json([
                'success'=>false,
                'messae'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Staffrequest $request)
    {
        try{
            $data=$this->staffservice->store(RegisterDTO::fromrequest($request));
            $status=fstatus($data);
            return response()->json($data,$status);
        }catch(Throwable $e){
            return response()->json([
                'success'=>false,
                'messae'=>$e->getMessage()
            ],500);
        }    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        
    }
}
