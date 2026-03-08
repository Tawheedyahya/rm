<?php

namespace App\Http\Controllers;

use App\DTOs\Superadmin\CreatehotelDTO;
use App\Http\Requests\Createhotelrequest;
use App\Services\Superadminservice;
use Illuminate\Http\Request;

class Superadmincontroller extends Controller
{
    //
    public function __construct(private Superadminservice $adminservice){}
    public function dashboard(){
        
    }
    public function create_hotel(Createhotelrequest $request,$id=null){
        $dto=CreatehotelDTO::fromRequest($request);
        if($id){
            $hotel=$this->adminservice->update_hotel($dto,$id);
        }else{
            $hotel = $this->adminservice->create_hotel($dto);
        }
        return response()->json($hotel);

    }
}
