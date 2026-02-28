<?php
namespace App\DTOs;
use App\Http\Requests\Resetpasswordrequest;

class ResetDTO{
    public function __construct
    (
        public string $email,
        public string $password,
        public string $token
    ){}
    public static function fromRequest(Resetpasswordrequest $request){
        return new ResetDTo($request->email,$request->password,$request->token);
    }
    
}
?>