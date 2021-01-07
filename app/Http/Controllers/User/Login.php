<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class Login extends Controller
{
    public function login(LoginRequest $loginRequest)
    {
        $code = $loginRequest->get('code');
    }

    public function register(RegisterRequest $registerRequest)
    {
        $data = $registerRequest->all();
    }
}