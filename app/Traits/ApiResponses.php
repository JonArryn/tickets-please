<?php

namespace App\Traits;

trait ApiResponses
{

    protected function ok($message, $data = []) {
        return $this->success($message, $data);
    }

    protected function success($message, $data = [], $statusCode = 200) {
        return response()->json([
            'message' => $message,
            'status'  => $statusCode,
            'data'    => $data,
        ], 200);
    }

    protected function error($message, $statusCode) {
        return response()->json([
            'message' => $message,
            'status'  => $statusCode,
        ]);
    }
}
