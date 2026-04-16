<?php
namespace App\Services;

use App\Models\Table;
use Illuminate\Http\Request;

class Tableservice{
    public function store(array $data): array
    {
        $user=auth('api')->user();
        if(!$user||!$user->hotel_id){
            return [
                'success'=>false,
                'status'=>403,
                'message'=>'User is not assigned to hotel'
            ];
        }
        // Table::create($data);
        $data['hotel_id'] = $user->hotel_id;

        Table::create($data);
        return [
            'success'=>true,
            'status'=>201,
            'message'=>'Table created successfully'
        ];
    }
}