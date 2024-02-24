<?php

namespace App\Traits;

trait HttpResponses
{
    protected function success($data, $code = 200)
    {
        return response()->json(['data' => $data, 'code' => $code], $code);
    }

    protected function createSuccess($data, $token = null, $code = 200)
    {
        return response()->json(['data' => $data, 'token' => $token, 'code' => $code], $code);
    }

    protected function error($error, $code)
    {
        return response()->json(["error" => $error, "code" => $code], $code);
    }

    protected function message($message, $code=200)
    {
        return response()->json(["message" => $message, "code" => $code], $code);
    }
}