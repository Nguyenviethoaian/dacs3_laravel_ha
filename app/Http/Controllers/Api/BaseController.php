<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    public function success(mixed $data, string $message= "okay", int $statusCode=200): JsonResponse
    {
        return response()->json([
            'data'=> $data,
            'success'=> true,
            'message'=> $message
        ], $statusCode);

    }
    
    public function error( string $message = "error", int $statusCode=400): JsonResponse 
    {
        return response()->json([
            'data'=> null,
            'success'=> false,
            'message'=> $message
        ], $statusCode);
    }

}
