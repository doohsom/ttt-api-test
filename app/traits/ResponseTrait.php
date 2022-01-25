<?php

namespace app\traits;

trait ResponseTrait{

    public function success($message, $status=200, $data = "")
    {
        echo json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $status);
        die();
    }

    public function failed($message, $status=400, $data = "")
    {
        echo json_encode([
            'status' => 'failure',
            'message' => $message,
            'error' => $data
        ], $status);
        die();
    }

    public function validation($message, $status=422, $data = "")
    {
        echo json_encode([
            'status' => 'failure',
            'message' => $message,
            'error' => $data
        ], $status);
        die();
    }
}