<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MessageException extends Exception
{
    public function __construct(string $message, int $code = 400)
    {
        parent::__construct($message, $code);
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        //
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function render(Request $request)
    {
        return response()->json([
            'status' => 'error',
            'message' => $this->getMessage()
        ], $this->getCode());
    }
}
