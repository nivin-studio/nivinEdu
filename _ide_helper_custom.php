<?php

namespace App\Api\Response\Facades {

/**
 * @see \App\Api\Response\ApiResponse
 */
    class Api
    {
        /**
         * response
         *
         * @param  array          $data
         * @param  int            $code
         * @param  string         $message
         * @return JsonResponse
         */
        public static function response($data = [], $code = 0, $message = 'ok')
        {
            /**
             * @var \App\Api\Response\ApiResponse $instance
             */
            return $instance->response($data, $code, $message);
        }

        /**
         * success
         *
         * @param  array                          $data
         * @param  \App\Api\Response\ApiCode|null $apiCode
         * @return JsonResponse
         */
        public static function success($data = [], $apiCode = null)
        {
            /**
             * @var \App\Api\Response\ApiResponse $instance
             */
            return $instance->success($data, $apiCode);
        }

        /**
         * ok
         *
         * @param  array                          $data
         * @param  \App\Api\Response\ApiCode|null $apiCode
         * @return JsonResponse
         */
        public static function ok($apiCode = null)
        {
            /**
             * @var \App\Api\Response\ApiResponse $instance
             */
            return $instance->ok($apiCode);
        }

        /**
         * error
         *
         * @param  \App\Api\Response\ApiCode $apiCode
         * @return JsonResponse
         */
        public static function error($apiCode)
        {
            /**
             * @var \App\Api\Response\ApiResponse $instance
             */
            return $instance->error($apiCode);
        }
    }

}
