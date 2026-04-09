<?php
namespace App\Swagger;
use OpenApi\Attributes as OA;

class HotelSwg{
    #[OA\Post(
        path:'/super_admin/create_hotel',
        summary:'Create hotel',
        tags:['Hotel'],
        security:[["bearerAuth"=>[]]],
        requestBody:new OA\RequestBody(
            required:true,
            content:new OA\MediaType(
                mediaType:"application/x-www-form-urlencoded",
                schema:new OA\Schema(
                    required:["name","email","phone","address","city","state","country","postal_code"],
                    properties:[
                        new OA\Property(property:"name",type:"string",example:"hotel_tag"),
                        new OA\Property(property:"email",type:"string",format:"email",example:"tawheedyahya0@gmail.com"),
                        new OA\Property(property:"phone",type:"string"),                    
                        new OA\Property(property: "address", type: "string", example: "Main Road"),
                        new OA\Property(property: "city", type: "string", example: "Chennai"),
                        new OA\Property(property: "state", type: "string", example: "Tamil Nadu"),
                        new OA\Property(property: "country", type: "string", example: "India"),
                        new OA\Property(property: "postal_code", type: "string", example: "600001"),
                    ]                
                )
            )
        ),
        responses:[
            new OA\Response(response:200,description:"hotel created successfully")
        ]
    )]
    public function hotel(){}
    
     #[OA\Put(
        path: "/super_admin/update_hotel/{id}",
        summary: "Update hotel",
        tags: ["Hotel"],
        security: [["bearerAuth" => []]],

        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer"),
                example: 1
            )
        ],

        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "application/x-www-form-urlencoded",
                schema: new OA\Schema(
                    required: ["name","email","phone","address","city","state","country","postal_code"],
                    properties: [
                        new OA\Property(property:"name",type:"string",example:"Hotel Taj"),
                        new OA\Property(property:"email",type:"string",format:"email",example:"test@gmail.com"),
                        new OA\Property(property:"phone",type:"string",example:"9876543210"),
                        new OA\Property(property:"address",type:"string",example:"Main Road"),
                        new OA\Property(property:"city",type:"string",example:"Chennai"),
                        new OA\Property(property:"state",type:"string",example:"Tamil Nadu"),
                        new OA\Property(property:"country",type:"string",example:"India"),
                        new OA\Property(property:"postal_code",type:"string",example:"600001"),
                    ]
                )
            )
        ),

        responses: [
            new OA\Response(response: 200, description: "Hotel updated successfully"),
            new OA\Response(response: 422, description: "Validation error")
        ]
    )]
    public function updateHotel() {}
}