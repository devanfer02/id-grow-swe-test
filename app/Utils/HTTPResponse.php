<?php

namespace App\Utils;

class HTTPResponse
{
    public static function send($status, $message, $code = 200, $data = null, $errors = null)
    {
        return response()->json([
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'errors' => $errors
        ], $code);
    }
}
