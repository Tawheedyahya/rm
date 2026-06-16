<?php

namespace App\Http\Controllers;

use App\DTOs\Superadmin\CreatehotelDTO;
use App\Http\Requests\Createhotelrequest;
use App\Models\Hotel;
use App\Services\Superadminservice;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
#[Group('SUPERADMIN')]
/**
 * @group Authentication
 */
class Superadmincontroller extends Controller
{
    //
    public function __construct(private Superadminservice $adminservice){}
    /**
     * DISPLAY ALL HOTELS
     **/
    public function index(){
        $page = request('page', 1);

        $hotels = Cache::tags(['hotels'])->remember("hotels.page.$page", 7200, function () {
        return Hotel::select('id','name','city','phone')
        ->paginate(20);
});

        return response()->json([
            'success' => true,
            'hotels' => $hotels->items(),
            'current_page' => $hotels->currentPage(),
            'next_page_url' => $hotels->nextPageUrl(),
            'prev_page_url' => $hotels->previousPageUrl(),
            'per_page' => $hotels->perPage(),
            'last_page' => $hotels->lastPage(),
            'last_page_url' => $hotels->url($hotels->lastPage()),
        ], 200);
    }
    /**
     * CREATE HOTEL
     */
    public function create_hotel(Createhotelrequest $request){
        $dto=CreatehotelDTO::fromRequest($request);
        $hotel = $this->adminservice->create_hotel($dto);
        
        return response()->json($hotel,$hotel['status']);

    }
    /**
     * UPDATE HOTEL         
     */
    public function update_hotel(Createhotelrequest $request,$id){
        $dto=CreatehotelDTO::fromRequest($request);
        $hotel=$this->adminservice->update_hotel($dto,$id);
        return response()->json($hotel,$hotel['status']);
    }
    /**
     * SHOW HOTEL
     */
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
