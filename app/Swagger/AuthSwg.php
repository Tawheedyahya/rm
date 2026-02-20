<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

class AuthSwg
{
    // ================= LOGIN =================
    #[OA\Post(
        path: "/login",
        summary: "Login API",
        tags: ["AUTH"],
        parameters: [
            new OA\Parameter(
                name: "Accept",
                in: "header",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    example: "application/json"
                )
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email"),
                    new OA\Property(property: "password", type: "string", format: "password")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Login successful"),
            new OA\Response(response: 401, description: "Invalid credentials")
        ]
    )]

    // ================= REGISTER =================
    #[OA\Post(
        path: "/register",
        summary: "Register API",
        tags: ["AUTH"],
        parameters: [
            new OA\Parameter(
                name: "Accept",
                in: "header",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    example: "application/json"
                )
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "email", "password", "password_confirmation"],
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "email", type: "string", format: "email"),
                    new OA\Property(property: "password", type: "string", format: "password"),
                    new OA\Property(property: "password_confirmation", type: "string", format: "password")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Register successfully"),
            new OA\Response(response: 400, description: "Validation error"),
            new OA\Response(response: 409, description: "Email already exists")
        ]
    )]
    #[OA\Post(
        path:"/token/refresh",
        summary:"Refresh token api",
        tags:["AUTH"],
        security:[["bearerAuth"=>[]]],
        parameters:[
            new OA\Parameter(
                name:"X-Refresh-Token",
                description:"Refresh token key",
                in:"header",
                required:true,
                schema:new OA\Schema(type:"string")
            )
        ],
        responses:[
            new OA\Response(response:200,description:"sucess"),
            new OA\Response(response:401,description:"UnAuthenticated")
        ]
    )]

    #[OA\Post(
        path:'/logout',
        summary:"Logout",
        tags:["AUTH"],
        security:[["bearerAuth"=>[]]],
        parameters:[
            new OA\Parameter(
                name:"X-Refresh-Token",
                description:"Refresh Token key",
                in:"header",
                required:true,
                schema:new OA\Schema(type:"string")
            )
        ],
        responses:[
            new OA\Response(response:200,description:"logout successfuly")
        ]
    )]
    #[OA\Get(
        path:'/profile',
        summary:'Profile',
        tags:["AUTH"],
        security:[["bearerAuth"=>[]]],
        responses:[
            new OA\Response(response:200,description:"Profile"),
            new OA\Response(response:401,description:"Unauthorize")
        ]
    )]

    public function auth(){}
}
