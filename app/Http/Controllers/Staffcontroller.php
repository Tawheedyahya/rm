<?php

namespace App\Http\Controllers;

use App\DTOs\Hoteladmin\RegisterDTO;
use App\Http\Requests\Staffrequest;
use App\Models\Role;
use App\Services\Staffservice;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Throwable;
#[Group('STAFF')]
class Staffcontroller extends Controller
{
    protected $staffservice;
    public function __construct(Staffservice $staffservice)
    {
        $this->staffservice=$staffservice;
    }
    /**
     * SHOW ALL STAFF BASED ON HOTEL
     **/
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
                'message'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * CREATE A STAFF FOR HOTEL
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
                'message'=>$e->getMessage()
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
    /**
     * ROLE SHOW
     * 
     */
    public function role_show(){
        try{
            $roles=Role::select('id','name')->whereNotIn('name',['super_admin','hotel_admin'])->get();
            return response()->json([
                'success'=>true,
                'roles'=>$roles
            ]);
        }catch(Throwable $e){
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ],500);
        }
    }
}
