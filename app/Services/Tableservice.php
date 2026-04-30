<?php
namespace App\Services;

use App\Models\Table;
use Illuminate\Http\Request;

class Tableservice{
    protected $user;
    public function __construct() {
        $this->user = auth('api')->user();
    }   
    public function index(): array
    {
        $tables=Table::where('hotel_id',$this->user->hotel_id)->get();
        return [
            'success'=>true,
            'status'=>200,
            'data'=>$tables
        ];
    }
    public function store(array $data): array
    {
        $data['hotel_id'] = $this->user->hotel_id;

        Table::create($data);
        return [
            'success'=>true,
            'status'=>201,
            'message'=>'Table created successfully'
        ];
    }
}