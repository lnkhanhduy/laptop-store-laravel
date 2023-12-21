<?php

namespace App\Http\Controllers;

trait UtilitiesTrait
{
    protected $linePerPageAdmin = 10;
    protected $linePerPageUser = 8;
    protected function successResponse($data, $message = 'Success', $status = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function errorResponse($message = 'Error', $status = 500)
    {
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }
}
