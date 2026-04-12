<?php

namespace App\Http\Controllers;

use App\DTOs\Superadmin\CreatehotelDTO;
use App\Http\Requests\Createhotelrequest;
use App\Models\Hotel;
use App\Services\Superadminservice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Superadmincontroller extends Controller
{
    //
    public function __construct(private Superadminservice $adminservice){}
    public function index(){
        $page = request('page', 1);

        $hotels = Cache::tags(['hotels'])->remember("hotels.page.$page", 7200, function () {
        return Hotel::select('id','name','city','phone')
        ->paginate(20);
});

        return response()->json([
            'success' => true,
            'data' => $hotels
        ],200);
    }
    public function create_hotel(Createhotelrequest $request,$id=null){
        $dto=CreatehotelDTO::fromRequest($request);
        if($id){
            $hotel=$this->adminservice->update_hotel($dto,$id);
        }else{
            $hotel = $this->adminservice->create_hotel($dto);
        }
        return response()->json($hotel,$hotel['status']);

    }
    public function show_hotel($id){
    $data = $this->adminservice->get_hotel($id);

    if (! $data['success']) {
        return response()->json([
            'message' => $data['message']
        ], $data['status']);
    }

    return response()->json([
        'success' => true,
        'hotel' => $data['data'],
        'message' => $data['message'],
    ], $data['status']);
}
}
