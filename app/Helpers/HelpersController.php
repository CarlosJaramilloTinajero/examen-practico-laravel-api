<?php

namespace App\Helpers;

class HelpersController
{
    function respondWithInternalServerError(string $msg = '')
    {
        return response('Server internal error ' . $msg, 500);
    }

    function responseWithFailApiMsg(string $msg = '', int $status = 200)
    {
        return response()->json(['status' => false, 'mgs' => $msg], $status);
    }

    function responseSuccessApi($data = [])
    {
        return response()->json(array_merge(['status' => true], ['data' => $data]));
    }
}
