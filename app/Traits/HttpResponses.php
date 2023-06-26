<?php

namespace App\Traits;

trait HttpResponses {

    protected function success ($data, $message=null, $code = 202) {
        return response()->json([
            'status' => 'Request was Succesful.',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error ($data, $message=null, $code) {
        return response()->json([
            'status' => 'Error has occurred.',
            'message' => $message,
            'data' => $data
        ], $code);
    }

}