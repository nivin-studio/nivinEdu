<?php

namespace App\Admin\Requests;

use Dcat\Admin\Admin;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    /**
     * 验证权限
     *
     * @return bool
     */
    public function authorize()
    {
        /**
         * 权限验证逻辑
         */
        return true;
    }

    /**
     * 验证规则
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => [
                'email',
                'required',
            ],
            'password' => [
                'required',
                'min:6',
            ],
        ];
    }

    /**
     * 错误消息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attribute不能为空',
            'string'   => ':attribute必须是字符',
            'max'      => ':attribute长度不应该大于:max',
            'min'      => ':attribute长度不应该小于:min',
            'exists'   => ':attribute不存在',
        ];
    }

    /**
     * 参数别名
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'email'    => '邮箱',
            'password' => '密码',
        ];
    }

    /**
     * 验证失败处理
     *
     * @param  Validator                $validator
     * @throws HttpResponseException
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        throw (
            new HttpResponseException(
                Admin::json()
                    ->withValidation($validator)
                    ->send()
            )
        );
    }
}
