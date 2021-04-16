<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
     */

    'accepted'             => ':attribute 是被接受的.',
    'active_url'           => ':attribute 必须是一个合法的 URL.',
    'after'                => ':attribute 必须是大于 :date.',
    'after_or_equal'       => ':attribute 必须是大于等于 :date.',
    'alpha'                => ':attribute 只能包含字母.',
    'alpha_dash'           => ':attribute 只能包含字母、数字、破折号和下划线.',
    'alpha_num'            => ':attribute 只能包含字母和数字.',
    'array'                => ':attribute 必须是数组.',
    'before'               => ':attribute 必须是小于 :date.',
    'before_or_equal'      => ':attribute 必须是小于等于 :date.',
    'between'              => [
        'numeric' => ':attribute 必须是在 :min 到 :max 之间.',
        'file'    => ':attribute 必须是在 :min 到 :max KB之间.',
        'string'  => ':attribute 必须是在 :min 到 :max 个字符之间.',
        'array'   => ':attribute 必须是在 :min 到 :max 项之间.',
    ],
    'boolean'              => ':attribute 必须是 true 或 false.',
    'confirmed'            => ':attribute 二次确认不匹配.',
    'date'                 => ':attribute 必须是一个合法的日期.',
    'date_equals'          => ':attribute 必须是等于 :date.',
    'date_format'          => ':attribute 与格式 :format 不符合.',
    'different'            => ':attribute 必须是不同于:other.',
    'digits'               => ':attribute 必须是 :digits 位.',
    'digits_between'       => ':attribute 必须是在 :min and :max 位之间.',
    'dimensions'           => ':attribute 必须是一个合法的图片.',
    'distinct'             => ':attribute 具有重复值.',
    'email'                => ':attribute 必须是一个合法的电子邮件地址.',
    'ends_with'            => ':attribute 必须是以 :values 结尾.',
    'exists'               => '选定的 :attribute 是无效的.',
    'file'                 => ':attribute 必须是一个合法的文件.',
    'filled'               => ':attribute 是必须的.',
    'gt'                   => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file'    => 'The :attribute must be greater than :value kilobytes.',
        'string'  => 'The :attribute must be greater than :value characters.',
        'array'   => 'The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file'    => 'The :attribute must be greater than or equal :value kilobytes.',
        'string'  => 'The :attribute must be greater than or equal :value characters.',
        'array'   => 'The :attribute must have :value items or more.',
    ],
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'The :attribute must be less than :value.',
        'file'    => 'The :attribute must be less than :value kilobytes.',
        'string'  => 'The :attribute must be less than :value characters.',
        'array'   => 'The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file'    => 'The :attribute must be less than or equal :value kilobytes.',
        'string'  => 'The :attribute must be less than or equal :value characters.',
        'array'   => 'The :attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => ':attribute 必须小于等于 :min.',
        'file'    => ':attribute 必须小于等于 :min KB.',
        'string'  => ':attribute 必须小于等于 :min 个字符.',
        'array'   => ':attribute 必须小于等于 :min 项.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute 必须大于等于 :min.',
        'file'    => ':attribute 必须大于等于 :min KB.',
        'string'  => ':attribute 必须大于等于 :min 个字符.',
        'array'   => ':attribute 必须大于等于 :min 项.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'not_regex'            => 'The :attribute format is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'password'             => 'The password is incorrect.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => ':attribute 字段必须填写.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values are present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'starts_with'          => 'The :attribute must start with one of the following: :values.',
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',
    'uuid'                 => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
     */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
     */

    'attributes' => [],

];
