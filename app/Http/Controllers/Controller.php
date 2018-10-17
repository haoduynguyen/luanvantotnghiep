<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function dataSuccess($mes, $data = [], $code)
    {
        return response()->json([
            'success' => true,
            'message' => $mes,
            'data' => $data
        ], $code);
    }

    public function dataError($mes, $data = [], $code)
    {
        return response()->json([
            'success' => false,
            'message' => $mes,
            'data' => $data,
        ], $code);
    }
}
