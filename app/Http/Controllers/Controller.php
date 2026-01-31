<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

#[
    OA\PathItem("/"),
    OA\Info(
        title: "Farmácia Pai e Filha API",
        version: "1.0.0",
        description: "API para gerenciamento da Farmácia Pai e Filha"
    ),
    OA\Server(
        url: "http://localhost:8000",
        description: "Servidor Local"
    ),
]
abstract class Controller
{
    //
}