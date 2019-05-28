<?php

namespace ChuJC\Validation;

use ChuJC\Validation\Rules\BackCard;
use ChuJC\Validation\Rules\IdCard;
use ChuJC\Validation\Rules\Password;

/**
 * Class Validate
 *
 * @method static bool chs(string $value)
 * @method static bool chs_alpha(string $value)
 * @method static bool chs_alpha_num(string $value)
 * @method static bool chs_dash(string $value)
 * @method static bool mobile(string $value)
 * @package ChuJC\Validation
 */
class Validate {

    protected static $regex = [
        'chs'            => '/^[\x{4e00}-\x{9fa5}]+$/u',
        'chs_alpha'      => '/^[\x{4e00}-\x{9fa5}a-zA-Z]+$/u',
        'chs_alpha_num'  => '/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]+$/u',
        'chs_dash'       => '/^[\x{4e00}-\x{9fa5}a-zA-Z0-9\_\-]+$/u',
        'mobile'         => '/^1[3-9][0-9]\d{8}$/',
    ];

    public static $message = [
        'chs'            => ':attribute只能是汉字',
        'chs_alpha'      => ':attribute只能是汉字、字母',
        'chs_alpha_num'  => ':attribute只能是汉字、字母和数字',
        'chs_dash'       => ':attribute只能是汉字、字母、数字和下划线_及破折号-',
        'mobile'         => ':attribute只能是手机号',
    ];

    public static function getRegex()
    {
        return static::$regex;
    }

    public static function id_card(string $id)
    {
        return IdCard::check($id);
    }

    public static function back_card(string $backCard)
    {
        return BackCard::check($backCard);
    }

    public static function password(string $value, $mode = 1)
    {
        return Password::check($value, $mode);
    }

    public static function __callStatic($name, $arguments)
    {
        strtolower($name);

        $reg = static::$regex[strtolower($name)];

        if (preg_match($reg, $arguments[0])) {
            return true;
        } else {
            return false;
        }
    }
}