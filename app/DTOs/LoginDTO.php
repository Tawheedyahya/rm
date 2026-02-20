<?php

namespace App\DTOs;

class LoginDTO
{
    public $email;
    public $password;
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
    public static function fromrequest($request)
    {
        return new LoginDTO(
            $request->email,
            $request->password
        );
    }
}
