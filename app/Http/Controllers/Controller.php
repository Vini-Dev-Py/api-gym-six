<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function success($message, $data, $statusCode)
    {
        return response()->json(['mensagem' => $message, 'data' => $data], $statusCode);
    }

    public function error($message, $statusCode)
    {
        return response()->json(['mensagem' => $message], $statusCode);
    }
}
