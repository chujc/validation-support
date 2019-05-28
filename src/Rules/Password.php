<?php

namespace ChuJC\Validation\Rules;

/**
 *
 * Class Password
 * @package ChuJC\Validation\Rules
 */
class Password
{

    /**
     * 密码强度验证等级：默认1级
     * 0级 纯数字 6位 特殊场景（二级密码，支付密码等）使用
     * 1级 必须包含数字、字母（不区分大小写）默认
     * 2级 必须包含数字、大小写字母
     * 3级 必须包含数字、大小写字母、特殊符号
     * @var array
     */
    private static $pattern = [
        '/^\d{6}$/',
        '/^(?=.*\d)(?=.*[a-zA-Z]).{2,}$/',
        '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{3,}$/',
        '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{4,}$/',
    ];

    public static $message = [
        ':attribute只能是6位存数字',
        ':attribute必须包含数字、字母',
        ':attribute必须包含数字、小写字母、大写字母',
        ':attribute必须包含数字、小写字母、大写字母、特殊字符',
    ];


    public static function check($value, $mode = 1): bool
    {
        return (bool) preg_match(static::$pattern[$mode], $value);
    }

}