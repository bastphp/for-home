<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Service\UserService;
use App\Repositories\UserRepositories;
use App\tools\Jwt;

class Login extends Controller
{
    public function login(LoginRequest $loginRequest): \Illuminate\Http\JsonResponse
    {
        $code = $loginRequest->get('code');
        $open_id = UserService::getOpenId($code);
        $user = UserRepositories::openId($open_id);
        $data['is_need'] = 0;
        $data['token']   = Jwt::makeToken($user->id,['user_id'=>$user->id]);
        if (empty($user->name)){
            $data['is_need'] = 1;
        }
        return $this->success($data, 'ok');
    }

    public function register(RegisterRequest $registerRequest): \Illuminate\Http\JsonResponse
    {
        $data = $registerRequest->all();
        UserRepositories::update($data);
        return $this->success([], '注册成功,开启你的回家之旅吧!');
    }
}