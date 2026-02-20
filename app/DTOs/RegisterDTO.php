<?php
namespace App\DTOs;

use App\Http\Requests\Registerrequest;

class RegisterDTO{
    public string $email;
    public string $password;
    public string $name;
    public function __construct($email,$password,$name)
    {
        $this->email=$email;
        $this->password=$password;
        $this->name=$name;
    }
    public static function fromrequest(Registerrequest $request){
        return new RegisterDTO(
            $request->email,$request->password,$request->name
        );
    }
    
}