<?php
namespace App\Services;

use App\DTOs\Hoteladmin\RegisterDTO;
use App\Models\User;

class Staffservice{
    public function store(RegisterDTO $registerDTO){
        $user=User::create($registerDTO->toArray());
        $data=[
            'data'=>$user,
            'success'=>true,
            'status'=>201,
            'message'=>$user->role->name.'created'
        ];
    }
}