<?php

namespace App\Http\Controllers;

use http\Env\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Repositories\Interfaces\HocKyRepositoryInterface;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(HocKyRepositoryInterface $hocKyRepository)
    {
        $this->hocKy = $hocKyRepository;
    }

    public function dataSuccess($mes, $data, $code)
    {
        return response()->json([
            'success' => true,
            'message' => $mes,
            'data' => $data
        ], $code);
    }

    public function dataError($mes, $data, $code)
    {
        return response()->json([
            'success' => false,
            'message' => $mes,
            'data' => $data,
        ], $code);
    }

}
