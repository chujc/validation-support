<?php

namespace ChuJC\Validation\Rules;


class BackCard
{

    public static function check(string $backCard)
    {
        // 这里为了兼容2017之前的版本，使用8~19位数字校验
        if (!preg_match('/^[1-9]{1}\d{7,18}$/', $backCard)) {
            return false;
        }

        if ((static::num($backCard) % 10 == 0)) {
            return true;
        }
        return false;
    }

    /**
     * @deprecated Luhn算法
     */
    private static function num(string $backCard)
    {
        $total = 0;

        for ($i = 0; $i < strlen($backCard); $i++) {

            $num = $backCard[$i];

            if ($i % 2 == 0) {

                $num = $backCard[$i] * 2;

                $num = intval($num / 10) + $num % 10;
            }

            $total += $num;
        }

        return $total;
    }
}