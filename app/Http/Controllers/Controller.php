<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function success($data, $msg, $code = 10000): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'msg'  => $msg,
            'data' => $data
        ]);
    }

}
