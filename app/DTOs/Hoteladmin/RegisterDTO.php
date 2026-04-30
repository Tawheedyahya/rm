<?php
namespace App\DTOs\Hoteladmin;

use App\Http\Requests\Staffrequest;

class RegisterDTO{
    public string $email;
    public string $password;
    public string $name;
    public string $role_id;
    public function __construct($email,$password,$name,$role_id)
    {
        $this->email=$email;
        $this->password=$password;
        $this->name=$name;
        $this->role_id=$role_id;
    }
    public static function fromrequest(Staffrequest $request){
        return new RegisterDTO(
            $request->email,$request->password,$request->name,$request->role_id
        );
    }
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role_id' => $this->role_id,
            'hotel_id' => auth('api')->user()->hotel_id,
        ];
    }
    
}