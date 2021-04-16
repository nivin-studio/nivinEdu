<?php

namespace App\Api\Middleware;

use App\Api\Response\ApiCode;
use App\Api\Response\Facades\Api;
use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JwtAuthenticate
{
    /**
     * The JWT Authenticator.
     *
     * @var \Tymon\JWTAuth\JWTGuard
     */
    protected $auth;

    /**
     * @param  $request
     * @param  Closure                        $next
     * @param  String                         $role
     * @return Illuminate\Http\JsonResponse
     */
    public function handle($request, Closure $next, $role = 'users')
    {
        try {
            $this->auth = Auth::guard($role)->setRequest($request);
            // 检查是否有token
            if (!$this->auth->getToken()) {
                return Api::error(ApiCode::make(ApiCode::CODE_3000));
            }
            // role验证
            if ($this->auth->getClaim('role') != $role) {
                return Api::error(ApiCode::make(ApiCode::CODE_3001));
            }
            // token验证
            if (!$this->auth->check()) {
                return Api::error(ApiCode::make(ApiCode::CODE_3001));
            }

            $response = $next($request);

            return $response;

        } catch (TokenExpiredException $e) {
            try {
                // token过期
                $token = $this->auth->refresh();

                $this->auth->byId($this->auth->factory()->buildClaimsCollection()->toPlainArray()['sub']);

                $response = $next($request);

                $response->headers->set('Authorization', 'Bearer ' . $token);

                return $response;

            } catch (Exception $e) {
                return Api::error(ApiCode::make(ApiCode::CODE_3003));
            }
        } catch (Exception $e) {
            return Api::error(ApiCode::make(ApiCode::CODE_3000));
        }
    }
}
