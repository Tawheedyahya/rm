<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "My API",
    version: "1.0.0"
)]
#[OA\Server(
    url: "http://127.0.0.1:8000/api",
    description: "Local server"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    description: "Enter JWT Bearer token",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
class ApiDocs {}