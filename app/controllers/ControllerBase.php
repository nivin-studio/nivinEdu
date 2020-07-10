<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

    /**
     * json输出
     *
     * @param  array  $data
     * @param  int    $status
     * @param  array  $headers
     * @return void
     */
    public function JsonResponse($data = [], $status = 200, $headers = [])
    {
        $response = new Response();
        $response->setStatusCode($status);
        $response->setJsonContent($data);

        if (!empty($headers)) {
            foreach ($headers as $key => $value) {
                $response->setHeader($key, $value);
            }
        }

        return $response;
    }
}
