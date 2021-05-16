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

namespace Illuminate\Support\Facades {
    /**
     *
     * @see \Illuminate\Auth\AuthManager
     * @see \Illuminate\Contracts\Auth\Factory
     * @see \Illuminate\Contracts\Auth\Guard
     * @see \Illuminate\Contracts\Auth\StatefulGuard
     */
    class Auth
    {
        /**
         * Attempt to get the guard from the local cache.
         *
         * @static
         * @param  string|null              $name
         * @return \Tymon\JWTAuth\JWTAuth
         */
        public static function guard($name = null)
        {
            /**
             * @var \Illuminate\Auth\AuthManager $instance
             */
            return $instance->guard($name);
        }
    }
}
