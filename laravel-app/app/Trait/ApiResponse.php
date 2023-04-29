<?php

namespace App\Trait;

trait ApiResponse
{
    /**
     * Success response json
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function successReponse($data = [], $code = 200)
    {
        return response()->json(
            ['data' => $data],
            $code
        );

    }
    
    /**
     * Error response json
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function errorResponse(string $message, $code = 400)
    {
        return response()->json(
            ['error' => $message],
            $code
        );
    }
}