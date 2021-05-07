<?php

namespace App\Utils;

use Hashids\Hashids as QuoteHashids;

class Hashids
{

    /**
     * 编码
     *
     * @param  int      $numbers 整数
     * @param  int      $length  长度
     * @return string
     */
    public static function encode($numbers, $length = 6)
    {
        $hashids = new QuoteHashids('', $length);

        return $hashids->encode($numbers);
    }

    /**
     * 解码
     *
     * @param  string $hash   编码字符
     * @param  int    $length 长度
     * @return int
     */
    public static function decode($hash, $length = 6)
    {
        $hashids = new QuoteHashids('', $length);

        $decode = $hashids->decode($hash);

        return isset($decode[0]) ? $decode[0] : '';
    }
}
