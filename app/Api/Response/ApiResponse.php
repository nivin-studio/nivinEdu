<?php

namespace App\Api\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Traits\Macroable;

class ApiResponse
{
    use Macroable;

    /**
     *
     * @param  array          $data
     * @param  int            $code
     * @param  string         $message
     * @return JsonResponse
     */
    public function response($data = [], $code = 0, $message = 'ok')
    {
        $json = array_merge(
            [
                'code'    => $code,
                'message' => $message,
            ],
            $data
        );

        return response()->json($json);
    }

    /**
     * success
     *
     * @param  array          $data
     * @param  ApiCode        $apiCode
     * @return JsonResponse
     */
    public function success($data = [], ApiCode $apiCode = null)
    {
        $apiCode = $apiCode ? $apiCode : ApiCode::make(ApiCode::CODE_OK);
        return $this->response($data ? ['data' => $data] : [], $apiCode->code, $apiCode->message);
    }

    /**
     * ok
     *
     * @param  array          $data
     * @param  ApiCode        $apiCode
     * @return JsonResponse
     */
    public function ok(ApiCode $apiCode = null)
    {
        $apiCode = $apiCode ? $apiCode : ApiCode::make(ApiCode::CODE_OK);
        return $this->response([], $apiCode->code, $apiCode->message);
    }

    /**
     * error
     *
     * @param  ApiCode        $apiCode
     * @return JsonResponse
     */
    public function error(ApiCode $apiCode)
    {
        return $this->response([], $apiCode->code, $apiCode->message);
    }
}
