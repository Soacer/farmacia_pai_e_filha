<?php

namespace App\Http\Controllers\Auth\User\useCases\CreateUser;

use OpenApi\Attributes as OA;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CreateUserController extends Controller
{
    public function createUser(Request $req){
        echo "entrou no createUserController";
    }

    private function insert(Request $req){

    }
}
